const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const ROOT_DIR = path.resolve(__dirname, '..', '..');
const OUTPUT_DIR = path.join(ROOT_DIR, 'updates', 'hot-updates');

function getModifiedFiles() {
  try {
    const statusOutput = execSync('git status --porcelain', { cwd: ROOT_DIR, encoding: 'utf-8' });
    const lines = statusOutput.split('\n').filter(Boolean);
    const files = [];

    const IGNORED_PREFIXES = [
      'data_local',
      'desktop/bin',
      'desktop/temp_downloads',
      'desktop/scripts/generate-hot-update.js',
      'node_modules',
      '.env',
      'banco.sql',
      '.git',
      'updates/hot-updates',
      'dist'
    ];

    for (const line of lines) {
      const match = line.match(/^[\s?MADRCU]{1,2}\s+(.+)$/);
      if (!match) continue;
      let filePath = match[1].trim();
      // Handle renamed files like "old -> new"
      if (filePath.includes('->')) {
        filePath = filePath.split('->')[1].trim();
      }
      // Remove any surrounding quotes
      filePath = filePath.replace(/^"|"$/g, '');

      const normalized = filePath.replace(/\\/g, '/');
      const shouldIgnore = IGNORED_PREFIXES.some(prefix => normalized.startsWith(prefix));

      if (!shouldIgnore && fs.existsSync(path.join(ROOT_DIR, normalized))) {
        // Only include if it's a file
        if (fs.statSync(path.join(ROOT_DIR, normalized)).isFile()) {
          files.push(normalized);
        }
      }
    }

    return files;
  } catch (err) {
    console.error('Erro ao verificar git status:', err.message);
    return [];
  }
}

function main() {
  const cliArgs = process.argv.slice(2);
  let filesToPack = cliArgs.length > 0 ? cliArgs : getModifiedFiles();

  if (filesToPack.length === 0) {
    console.log('Nenhum arquivo modificado detectado para gerar o pacote Hot-Update.');
    return;
  }

  if (!fs.existsSync(OUTPUT_DIR)) {
    fs.mkdirSync(OUTPUT_DIR, { recursive: true });
  }

  const now = new Date();
  const pad = n => String(n).padStart(2, '0');
  const dateStr = `${now.getFullYear()}${pad(now.getMonth() + 1)}${pad(now.getDate())}_${pad(now.getHours())}${pad(now.getMinutes())}${pad(now.getSeconds())}`;
  
  let pkgVersion = '1.0.0';
  try {
    const pkg = JSON.parse(fs.readFileSync(path.join(ROOT_DIR, 'package.json'), 'utf-8'));
    pkgVersion = pkg.version || '1.0.0';
  } catch (e) {}

  const zipName = `hot-update-v${pkgVersion}-${dateStr}.zip`;
  const zipPath = path.join(OUTPUT_DIR, zipName);
  const stagingDir = path.join(OUTPUT_DIR, `staging_${Date.now()}`);

  try {
    fs.mkdirSync(stagingDir, { recursive: true });

    console.log(`\n======================================================`);
    console.log(`GERADOR DE PACOTE HOT-UPDATE (MODULAR) - AMURA OS`);
    console.log(`======================================================`);
    console.log(`Arquivos incluídos no pacote (${filesToPack.length}):`);

    for (const relPath of filesToPack) {
      const src = path.join(ROOT_DIR, relPath);
      const dest = path.join(stagingDir, relPath);

      if (!fs.existsSync(src)) {
        console.warn(`[AVISO] Arquivo não encontrado: ${relPath}`);
        continue;
      }

      fs.mkdirSync(path.dirname(dest), { recursive: true });
      fs.copyFileSync(src, dest);
      console.log(`  + ${relPath}`);
    }

    // Criar manifesto de atualização no pacote
    const manifest = {
      name: 'Amura OS Hot-Update',
      version: pkgVersion,
      generatedAt: now.toISOString(),
      files: filesToPack
    };
    fs.writeFileSync(path.join(stagingDir, 'update-manifest.json'), JSON.stringify(manifest, null, 2), 'utf-8');

    // Comprimir usando PowerShell
    const cmd = `powershell -NoProfile -Command "Compress-Archive -Path '${stagingDir}\\*' -DestinationPath '${zipPath}' -Force"`;
    execSync(cmd, { stdio: 'inherit' });

    const stats = fs.statSync(zipPath);
    const sizeKb = (stats.size / 1024).toFixed(2);

    console.log(`\n------------------------------------------------------`);
    console.log(`PACOTE GERADO COM SUCESSO!`);
    console.log(`Arquivo: ${zipPath}`);
    console.log(`Tamanho: ${sizeKb} KB`);
    console.log(`------------------------------------------------------`);
    console.log(`Como instalar no Amura OS Desktop:`);
    console.log(`1. Abra o aplicativo Amura OS Desktop`);
    console.log(`2. Acesse o menu: Arquivo -> Instalar Pacote de Atualização (.zip)...`);
    console.log(`3. Selecione o arquivo acima gerado.`);
    console.log(`======================================================\n`);

    // Criar também uma cópia como latest-hot-update.zip para conveniência
    const latestPath = path.join(OUTPUT_DIR, 'latest-hot-update.zip');
    fs.copyFileSync(zipPath, latestPath);

  } catch (err) {
    console.error('Falha ao gerar o pacote Hot-Update:', err.message);
    process.exitCode = 1;
  } finally {
    if (fs.existsSync(stagingDir)) {
      fs.rmSync(stagingDir, { recursive: true, force: true });
    }
  }
}

main();
