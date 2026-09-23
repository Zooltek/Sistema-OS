const { spawn, spawnSync, exec, execSync } = require('child_process');
const path = require('path');
const fs = require('fs');
const http = require('http');

class ProcessManager {
  constructor(app, isPackaged) {
    this.app = app;
    this.isPackaged = isPackaged;

    if (this.isPackaged) {
      this.appRoot = path.join(process.resourcesPath, 'app');
      this.desktopDir = path.join(this.appRoot, 'desktop');
      this.binDir = path.join(this.desktopDir, 'bin');
    } else {
      this.desktopDir = path.resolve(__dirname, '..');
      this.appRoot = path.resolve(this.desktopDir, '..');
      this.binDir = path.join(this.desktopDir, 'bin');
    }

    this.phpBinDir = path.join(this.binDir, 'php');
    this.phpExe = path.join(this.phpBinDir, 'php.exe');
    this.phpIni = path.join(this.phpBinDir, 'php.ini');

    this.mariaBinDir = path.join(this.binDir, 'mariadb', 'bin');
    this.mysqldExe = path.join(this.mariaBinDir, 'mysqld.exe');
    this.mysqlExe = path.join(this.mariaBinDir, 'mysql.exe');
    this.mysqladminExe = path.join(this.mariaBinDir, 'mysqladmin.exe');
    this.installDbExe = path.join(this.mariaBinDir, 'mariadb-install-db.exe');
    this.myIni = path.join(this.binDir, 'mariadb', 'my.ini');

    this.routerScript = path.join(this.desktopDir, 'server', 'router.php');
    this.backupScript = path.join(this.desktopDir, 'server', 'backup.php');
    this.bancoSql = path.join(this.appRoot, 'banco.sql');

    // Determinar diretório de dados persistentes
    const isPortable = !!process.env.PORTABLE_EXECUTABLE_DIR;
    const exeDir = process.env.PORTABLE_EXECUTABLE_DIR || (this.isPackaged ? path.dirname(process.execPath) : null);
    const adjacentDataDir = exeDir ? path.join(exeDir, 'AmuraOS_Data') : null;
    const parentDataDir = exeDir ? path.join(path.dirname(exeDir), 'AmuraOS_Data') : null;
    const distDataDir = path.join(this.appRoot, 'dist', 'AmuraOS_Data');

    if (isPortable) {
      this.dataDir = path.join(process.env.PORTABLE_EXECUTABLE_DIR, 'AmuraOS_Data');
    } else if (adjacentDataDir && fs.existsSync(adjacentDataDir)) {
      this.dataDir = adjacentDataDir;
    } else if (parentDataDir && fs.existsSync(parentDataDir)) {
      this.dataDir = parentDataDir;
    } else if (fs.existsSync(distDataDir)) {
      this.dataDir = distDataDir;
    } else if (this.isPackaged) {
      this.dataDir = path.join(this.app.getPath('userData'), 'AmuraOS_Data');
    } else {
      this.dataDir = path.join(this.appRoot, 'data_local');
    }

    this.dbDataDir = path.join(this.dataDir, 'db');
    this.logsDir = path.join(this.dataDir, 'logs');
    this.logFile = path.join(this.logsDir, 'app_debug.log');
    this.phpErrorLog = path.join(this.logsDir, 'php_error.log');
    this.configFile = path.join(this.dataDir, 'desktop_config.json');

    this.mysqlProcess = null;
    this.phpProcess = null;
    this.isShuttingDown = false;
    this.phpRestartTimeout = null;

    // Carregar configurações locais (modo rede)
    this.config = {
      networkSharing: false
    };
    try {
      if (fs.existsSync(this.configFile)) {
        const saved = JSON.parse(fs.readFileSync(this.configFile, 'utf8'));
        this.config = Object.assign(this.config, saved);
      }
    } catch (e) {
      console.error('Erro ao ler desktop_config.json:', e);
    }

    // Criar diretórios necessários
    try {
      if (!fs.existsSync(this.dataDir)) fs.mkdirSync(this.dataDir, { recursive: true });
      if (!fs.existsSync(this.dbDataDir)) fs.mkdirSync(this.dbDataDir, { recursive: true });
      if (!fs.existsSync(this.logsDir)) fs.mkdirSync(this.logsDir, { recursive: true });
    } catch (err) {
      console.error('Erro ao criar pastas de dados/logs:', err);
    }
  }

  saveConfig() {
    try {
      fs.writeFileSync(this.configFile, JSON.stringify(this.config, null, 2), 'utf8');
    } catch (err) {
      this.log(`Erro ao salvar desktop_config.json: ${err.message}`, 'AVISO');
    }
  }

  log(msg, level = 'INFO') {
    const levelTag = String(level).padEnd(5);
    const line = `[${new Date().toISOString()}] [${levelTag}] ${msg}\n`;
    try {
      if (fs.existsSync(this.logFile)) {
        const stat = fs.statSync(this.logFile);
        if (stat.size >= 5 * 1024 * 1024) { // 5MB max
          const oldLog = this.logFile + '.old';
          if (fs.existsSync(oldLog)) fs.unlinkSync(oldLog);
          fs.renameSync(this.logFile, oldLog);
        }
      }
      fs.appendFileSync(this.logFile, line);
    } catch {}
    console.log(`[ProcessManager] [${levelTag}] ${msg}`);
  }

  async start(onProgress) {
    this.log('Iniciando ciclo de vida dos serviços Amura OS...');
    this.log(`Diretório de dados: ${this.dataDir}`);
    this.log(`Diretório de logs: ${this.logsDir}`);

    if (onProgress) onProgress('Verificando banco de dados...');
    await this.initDatabaseIfNeeded(onProgress);

    if (onProgress) onProgress('Iniciando serviço de banco de dados...');
    await this.startMariaDB();

    if (onProgress) onProgress('Verificando tabelas do sistema...');
    await this.importInitialSchemaIfNeeded(onProgress);

    if (onProgress) onProgress('Iniciando servidor web Amura OS...');
    await this.startPhpServer();

    if (onProgress) onProgress('Aguardando resposta do servidor...');
    await this.waitForHttpServer('http://127.0.0.1:8002', 30);
  }

  async initDatabaseIfNeeded(onProgress) {
    const mysqlSysDb = path.join(this.dbDataDir, 'mysql');
    if (!fs.existsSync(mysqlSysDb)) {
      if (onProgress) onProgress('Inicializando arquivos do MariaDB...');
      this.log('Inicializando estrutura do MariaDB com mariadb-install-db...');
      const cleanDbPath = this.dbDataDir.replace(/\\/g, '/');
      try {
        spawnSync(this.installDbExe, [`--datadir=${cleanDbPath}`], { windowsHide: true, stdio: 'ignore' });
        this.log('Banco de dados inicializado com sucesso.');
      } catch (err) {
        this.log(`Aviso na inicialização do banco: ${err.message}`, 'AVISO');
      }
    }
  }

  async startMariaDB() {
    return new Promise((resolve, reject) => {
      this.log('Iniciando mysqld.exe na porta 3307...');
      const cleanDbPath = this.dbDataDir.replace(/\\/g, '/');
      const cleanMyIni = this.myIni.replace(/\\/g, '/');

      const args = [
        `--defaults-file=${cleanMyIni}`,
        `--datadir=${cleanDbPath}`,
        '--port=3307',
        '--bind-address=127.0.0.1',
        '--console'
      ];

      this.mysqlProcess = spawn(this.mysqldExe, args, {
        cwd: this.mariaBinDir,
        windowsHide: true,
        stdio: 'pipe'
      });

      let isResolved = false;
      let attempts = 0;
      let lastStderr = '';

      const finish = (success, errMsg) => {
        if (!isResolved) {
          isResolved = true;
          clearInterval(checkPing);
          if (success) {
            resolve();
          } else {
            const detail = errMsg || lastStderr || 'Falha ao inicializar o banco de dados MariaDB na porta 3307.';
            reject(new Error(detail));
          }
        }
      };

      this.mysqlProcess.on('error', (err) => {
        this.log(`Erro no processo MariaDB: ${err.message}`, 'ERRO');
        finish(false, `Não foi possível executar o MariaDB: ${err.message}`);
      });

      if (this.mysqlProcess.stderr) {
        this.mysqlProcess.stderr.on('data', (data) => {
          const msg = data.toString().trim();
          if (msg) {
            lastStderr = msg;
            this.log(`[MariaDB STDERR] ${msg}`, 'AVISO');
          }
        });
      }

      this.mysqlProcess.on('exit', (code, signal) => {
        if (!isResolved && code !== 0) {
          this.log(`MariaDB encerrou prematuramente (code: ${code}, signal: ${signal}).`, 'ERRO');
          finish(false, `O serviço de banco de dados encerrou inesperadamente (código ${code}).`);
        }
      });

      let isChecking = false;
      const checkPing = setInterval(() => {
        if (isResolved || isChecking) return;
        attempts++;
        isChecking = true;
        const pingChild = spawn(this.mysqladminExe, ['-h', '127.0.0.1', '-P', '3307', '-u', 'root', 'ping'], {
          windowsHide: true
        });
        let pingOut = '';
        if (pingChild.stdout) {
          pingChild.stdout.on('data', (d) => { pingOut += d.toString(); });
        }
        pingChild.on('close', (code) => {
          isChecking = false;
          if (isResolved) return;
          if (code === 0 && pingOut.includes('alive')) {
            this.log('MariaDB está pronto e respondendo (alive).');
            finish(true);
          } else if (attempts >= 120) { // 30 segundos
            this.log('Atingiu limite de tentativas para MariaDB ping.', 'ERRO');
            finish(false, 'Tempo limite excedido (30s) aguardando o banco de dados MariaDB na porta 3307.');
          }
        });
        pingChild.on('error', () => {
          isChecking = false;
        });
      }, 250);
    });
  }

  async importInitialSchemaIfNeeded(onProgress) {
    try {
      this.log('Verificando existência do banco de dados amura_os...');
      const checkRes = spawnSync(this.mysqlExe, ['-h', '127.0.0.1', '-P', '3307', '-u', 'root', '-e', 'SHOW DATABASES LIKE "amura_os";'], {
        encoding: 'utf8',
        windowsHide: true
      });
      const stdout = checkRes.stdout || '';

      if (!stdout.includes('amura_os')) {
        if (onProgress) onProgress('Criando banco e importando dados iniciais...');
        this.log('Banco amura_os não encontrado. Criando e importando banco.sql...');

        spawnSync(this.mysqlExe, ['-h', '127.0.0.1', '-P', '3307', '-u', 'root', '-e', 'CREATE DATABASE IF NOT EXISTS amura_os CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'], {
          windowsHide: true
        });

        if (fs.existsSync(this.bancoSql)) {
          const sqlContent = fs.readFileSync(this.bancoSql);
          spawnSync(this.mysqlExe, ['-h', '127.0.0.1', '-P', '3307', '-u', 'root', 'amura_os'], {
            input: sqlContent,
            windowsHide: true
          });
          this.log('banco.sql importado com sucesso!');
        }
      } else {
        this.log('Banco de dados amura_os já existe.');
      }

      // Sanitizar/Garantir credenciais do administrador padrão caso necessário
      try {
        const hashAdmin = '$2y$10$m/ST/CNtsHa63neTDTLMIOkadWFOpTdn.9p5jPOwnvLeZ96DB.pOi';
        const fixUserSql = `
          SET SESSION sql_mode = '';
          UPDATE amura_os.permissoes SET data = CURDATE() WHERE idPermissao = 1 AND (data < '2000-01-01' OR data IS NULL);
          UPDATE amura_os.usuarios SET nome = 'Administrador', email = 'admin@admin.com', senha = '${hashAdmin}', situacao = 1, dataExpiracao = '3000-01-01', dataCadastro = CURDATE() WHERE idUsuarios = 1 AND (email = 'admin_email' OR senha = 'admin_password');
          INSERT IGNORE INTO amura_os.usuarios (idUsuarios, nome, rg, cpf, cep, rua, numero, bairro, cidade, estado, email, senha, telefone, celular, situacao, dataCadastro, permissoes_id, dataExpiracao)
          VALUES (1, 'Administrador', 'MG-25.502.560', '600.021.520-87', '70005-115', 'Rua Acima', '12', 'Alvorada', 'Teste', 'MG', 'admin@admin.com', '${hashAdmin}', '000000-0000', '', 1, CURDATE(), 1, '3000-01-01');
        `;
        spawnSync(this.mysqlExe, ['-h', '127.0.0.1', '-P', '3307', '-u', 'root', '-e', fixUserSql.replace(/\r?\n/g, ' ')], {
          windowsHide: true
        });
      } catch (sanityErr) {
        this.log(`Aviso ao verificar credenciais de usuário: ${sanityErr.message}`, 'AVISO');
      }
    } catch (dbErr) {
      this.log(`Erro ao verificar banco de dados: ${dbErr.message}`, 'AVISO');
    }
  }

  async startPhpServer() {
    if (this.isShuttingDown) return;

    const host = this.config.networkSharing ? '0.0.0.0' : '127.0.0.1';
    this.log(`Iniciando servidor PHP embutido no host ${host}:8002 (Rede Local: ${this.config.networkSharing ? 'ATIVADA' : 'DESATIVADA'})...`);
    
    const env = Object.assign({}, process.env, {
      DB_HOSTNAME: '127.0.0.1',
      DB_PORT: '3307',
      DB_USERNAME: 'root',
      DB_PASSWORD: '',
      DB_DATABASE: 'amura_os',
      DB_DRIVER: 'mysqli',
      APP_BASEURL: 'http://127.0.0.1:8002/'
    });

    const cleanPhpErrorLog = this.phpErrorLog.replace(/\\/g, '/');

    const args = [
      '-S', `${host}:8002`,
      '-c', this.phpIni,
      '-d', `error_log=${cleanPhpErrorLog}`,
      this.routerScript
    ];

    this.phpProcess = spawn(this.phpExe, args, {
      cwd: this.appRoot,
      env: env,
      windowsHide: true,
      stdio: ['ignore', 'pipe', 'pipe']
    });

    this.phpProcess.stdout.on('data', (data) => {
      const msg = data.toString().trim();
      if (msg) this.log(`[PHP] ${msg}`);
    });

    this.phpProcess.stderr.on('data', (data) => {
      const msg = data.toString().trim();
      if (msg) this.log(`[PHP] ${msg}`);
    });

    this.phpProcess.on('error', (err) => {
      this.log(`Erro no processo PHP: ${err.message}`, 'ERRO');
    });

    // BLINDAGEM: Auto-Restart do PHP em caso de crash inesperado
    this.phpProcess.on('exit', (code, signal) => {
      if (!this.isShuttingDown) {
        this.log(`Servidor PHP encerrou inesperadamente (code: ${code}, signal: ${signal}). Auto-restart em 600ms...`, 'AVISO');
        clearTimeout(this.phpRestartTimeout);
        this.phpRestartTimeout = setTimeout(() => {
          if (!this.isShuttingDown) {
            this.startPhpServer();
          }
        }, 600);
      } else {
        this.log('Servidor PHP finalizado com sucesso.');
      }
    });
  }

  async waitForHttpServer(url, maxSeconds = 30) {
    return new Promise((resolve, reject) => {
      let elapsed = 0;
      let isDone = false;
      const interval = setInterval(() => {
        if (isDone) return;
        elapsed += 0.25;
        if (elapsed >= maxSeconds) {
          isDone = true;
          clearInterval(interval);
          reject(new Error('Tempo limite excedido aguardando servidor web local.'));
          return;
        }

        http.get(url, (res) => {
          if (isDone) return;
          if (res.statusCode >= 200 && res.statusCode < 500) {
            isDone = true;
            clearInterval(interval);
            this.log(`Servidor web respondeu com status ${res.statusCode}.`);
            resolve();
          }
        }).on('error', () => {
          // Servidor ainda não aceitando conexões
        });
      }, 250);
    });
  }

  // Backup do Banco de Dados MariaDB em formato .sql
  async backupDatabase(destinationPath) {
    return new Promise((resolve, reject) => {
      this.log(`Iniciando geração de backup em: ${destinationPath}`);
      const env = Object.assign({}, process.env, {
        DB_HOSTNAME: '127.0.0.1',
        DB_PORT: '3307',
        DB_USERNAME: 'root',
        DB_PASSWORD: '',
        DB_DATABASE: 'amura_os'
      });

      const args = [
        '-c', this.phpIni,
        this.backupScript,
        destinationPath
      ];

      const backupProc = spawn(this.phpExe, args, {
        cwd: this.appRoot,
        env: env,
        windowsHide: true,
        stdio: ['ignore', 'pipe', 'pipe']
      });

      let stderrOutput = '';
      backupProc.stderr.on('data', (d) => {
        stderrOutput += d.toString();
      });

      backupProc.on('exit', (code) => {
        if (code === 0 && fs.existsSync(destinationPath) && fs.statSync(destinationPath).size > 0) {
          const fileSizeKb = Math.round(fs.statSync(destinationPath).size / 1024);
          this.log(`Backup concluído com sucesso! Tamanho: ${fileSizeKb} KB`);
          resolve({ success: true, sizeKb: fileSizeKb });
        } else {
          const err = stderrOutput.trim() || `Processo de backup encerrou com código ${code}`;
          this.log(`Falha na geração de backup: ${err}`, 'ERRO');
          reject(new Error(err));
        }
      });

      backupProc.on('error', (err) => {
        this.log(`Erro ao executar rotina de backup: ${err.message}`, 'ERRO');
        reject(err);
      });
    });
  }

  // Alternar compartilhamento em rede local (0.0.0.0 vs 127.0.0.1)
  async setNetworkSharing(enabled) {
    this.config.networkSharing = !!enabled;
    this.saveConfig();
    this.log(`Modo de rede local alterado para: ${this.config.networkSharing ? 'ATIVADO (0.0.0.0:8002)' : 'DESATIVADO (127.0.0.1:8002)'}`);

    // Reiniciar servidor PHP para aplicar novo bind
    if (this.phpProcess) {
      this.isShuttingDown = true;
      try {
        this.phpProcess.kill();
        exec(`taskkill /PID ${this.phpProcess.pid} /T /F`, () => {});
      } catch (e) {}
      await new Promise(r => setTimeout(r, 400));
      this.isShuttingDown = false;
      await this.startPhpServer();
      await this.waitForHttpServer('http://127.0.0.1:8002', 15);
    }
    return { success: true, networkSharing: this.config.networkSharing };
  }

  // Obter endereços IP locais (IPv4) de placas ativas
  getLocalIpAddresses() {
    const os = require('os');
    const interfaces = os.networkInterfaces();
    const ips = [];

    for (const name of Object.keys(interfaces)) {
      for (const iface of interfaces[name]) {
        // Apenas IPv4 e não interno (não loopback)
        if (iface.family === 'IPv4' && !iface.internal) {
          ips.push({
            name: name,
            address: iface.address,
            url: `http://${iface.address}:8002`
          });
        }
      }
    }
    return ips;
  }

  // Restauração de Banco de Dados MariaDB a partir de arquivo .sql
  async restoreDatabase(sourceSqlPath) {
    return new Promise(async (resolve, reject) => {
      if (!fs.existsSync(sourceSqlPath)) {
        return reject(new Error('Arquivo de backup selecionado não foi encontrado.'));
      }

      this.log(`Iniciando restauração do banco de dados a partir de: ${sourceSqlPath}`);

      // 1. Criar backup preventivo automático antes de sobrescrever
      const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
      const safetyBackupPath = path.join(this.dataDir, `backup-pre-restore-${timestamp}.sql`);
      try {
        await this.backupDatabase(safetyBackupPath);
        this.log(`Backup de contingência criado em: ${safetyBackupPath}`);
      } catch (backupErr) {
        this.log(`Aviso ao criar backup de segurança: ${backupErr.message}`, 'AVISO');
      }

      // 2. Executar importação via powershell / mysql.exe
      const restoreCmd = `powershell -Command "Get-Content -Path '${sourceSqlPath}' -Raw | & '${this.mysqlExe}' -h 127.0.0.1 -P 3307 -u root amura_os"`;
      exec(restoreCmd, (err, stdout, stderr) => {
        if (err) {
          const errMsg = stderr || err.message;
          this.log(`Falha na restauração do banco: ${errMsg}`, 'ERRO');
          return reject(new Error(`Erro ao restaurar banco de dados: ${errMsg}`));
        }

        this.log('Banco de dados restaurado com sucesso!');
        resolve({ success: true, safetyBackup: safetyBackupPath });
      });
    });
  }

  // Aplicar Pacote de Atualização (.zip) sem recompilação e sem perder dados
  async applyUpdatePackage(zipFilePath) {
    return new Promise(async (resolve, reject) => {
      if (!fs.existsSync(zipFilePath)) {
        return reject(new Error('Arquivo de atualização .zip não encontrado.'));
      }

      this.log(`Iniciando aplicação de pacote de atualização: ${zipFilePath}`);

      // 1. Fazer backup preventivo do banco
      const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
      const backupPath = path.join(this.dataDir, `backup-pre-update-${timestamp}.sql`);
      try {
        await this.backupDatabase(backupPath);
        this.log(`Backup preventivo de atualização criado em: ${backupPath}`);
      } catch (e) {
        this.log(`Aviso no backup pré-atualização: ${e.message}`, 'AVISO');
      }

      // 2. Extrair arquivos do .zip diretamente sobre a pasta da aplicação
      const extractCmd = `powershell -Command "Expand-Archive -Path '${zipFilePath}' -DestinationPath '${this.appRoot}' -Force"`;
      exec(extractCmd, async (err, stdout, stderr) => {
        if (err) {
          const errMsg = stderr || err.message;
          this.log(`Erro ao extrair pacote de atualização: ${errMsg}`, 'ERRO');
          return reject(new Error(`Falha na extração dos arquivos: ${errMsg}`));
        }

        this.log('Arquivos do pacote extraídos com sucesso.');

        // 3. Executar migrações do banco de dados (se houver migration pendente)
        try {
          const migrateCmd = `"${this.phpExe}" -c "${this.phpIni}" "${path.join(this.appRoot, 'index.php')}" tools migrate`;
          execSync(migrateCmd, {
            cwd: this.appRoot,
            env: Object.assign({}, process.env, {
              DB_HOSTNAME: '127.0.0.1',
              DB_PORT: '3307',
              DB_USERNAME: 'root',
              DB_PASSWORD: '',
              DB_DATABASE: 'amura_os'
            })
          });
          this.log('Migrações de banco de dados executadas com sucesso.');
        } catch (migErr) {
          this.log(`Aviso ao rodar migrações: ${migErr.message}`, 'AVISO');
        }

        resolve({ success: true, backupSafety: backupPath });
      });
    });
  }

  async stopAll() {
    if (this.isShuttingDown) return;
    this.isShuttingDown = true;
    clearTimeout(this.phpRestartTimeout);
    this.log('Encerrando serviços de suporte (PHP e MariaDB)...');

    if (this.phpProcess && !this.phpProcess.killed) {
      try {
        this.phpProcess.kill();
        spawn('taskkill', ['/PID', String(this.phpProcess.pid), '/T', '/F'], { windowsHide: true });
      } catch (e) {}
    }

    try {
      spawnSync(this.mysqladminExe, ['-h', '127.0.0.1', '-P', '3307', '-u', 'root', 'shutdown'], { windowsHide: true, stdio: 'ignore' });
    } catch (e) {
      if (this.mysqlProcess && !this.mysqlProcess.killed) {
        try {
          this.mysqlProcess.kill();
          spawn('taskkill', ['/PID', String(this.mysqlProcess.pid), '/T', '/F'], { windowsHide: true });
        } catch (err) {}
      }
    }
  }
}

module.exports = ProcessManager;
