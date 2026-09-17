const fs = require('fs');
const path = require('path');
const https = require('https');
const http = require('http');
const { execSync } = require('child_process');

const DESKTOP_DIR = path.resolve(__dirname, '..');
const BIN_DIR = path.join(DESKTOP_DIR, 'bin');
const PHP_DIR = path.join(BIN_DIR, 'php');
const MARIADB_DIR = path.join(BIN_DIR, 'mariadb');
const TEMP_DIR = path.join(DESKTOP_DIR, 'temp_downloads');

const PHP_URL = 'https://windows.php.net/downloads/releases/php-8.2.33-nts-Win32-vs16-x64.zip';
const MARIADB_URL = 'https://archive.mariadb.org/mariadb-10.6.18/winx64-packages/mariadb-10.6.18-winx64.zip';
const COMPOSER_URL = 'https://getcomposer.org/download/latest-stable/composer.phar';

function downloadFile(url, dest) {
  return new Promise((resolve, reject) => {
    console.log(`[Download] Baixando ${url}...`);
    const file = fs.createWriteStream(dest);
    const get = (targetUrl) => {
      const client = targetUrl.startsWith('https') ? https : http;
      client.get(targetUrl, (response) => {
        if (response.statusCode >= 300 && response.statusCode < 400 && response.headers.location) {
          return get(response.headers.location);
        }
        if (response.statusCode !== 200) {
          return reject(new Error(`Failed to download: status ${response.statusCode}`));
        }
        const total = parseInt(response.headers['content-length'], 10) || 0;
        let downloaded = 0;
        let lastPercent = 0;
        response.on('data', (chunk) => {
          downloaded += chunk.length;
          if (total > 0) {
            const percent = Math.floor((downloaded / total) * 100);
            if (percent >= lastPercent + 10) {
              console.log(`[Download] ${percent}% (${Math.round(downloaded / 1024 / 1024)}MB / ${Math.round(total / 1024 / 1024)}MB)`);
              lastPercent = percent;
            }
          }
        });
        response.pipe(file);
        file.on('finish', () => {
          file.close(resolve);
        });
      }).on('error', (err) => {
        fs.unlink(dest, () => {});
        reject(err);
      });
    };
    get(url);
  });
}

function extractZip(zipPath, destDir) {
  console.log(`[Extract] Extraindo ${zipPath} para ${destDir}...`);
  fs.mkdirSync(destDir, { recursive: true });
  execSync(`powershell -Command "Expand-Archive -Path '${zipPath}' -DestinationPath '${destDir}' -Force"`, { stdio: 'inherit' });
}

async function setupPHP() {
  if (fs.existsSync(path.join(PHP_DIR, 'php.exe'))) {
    console.log('[PHP] PHP já instalado em ' + PHP_DIR);
    return;
  }
  const phpZip = path.join(TEMP_DIR, 'php.zip');
  await downloadFile(PHP_URL, phpZip);
  extractZip(phpZip, PHP_DIR);

  // Criar php.ini
  const phpIniContent = `
[PHP]
engine = On
short_open_tag = On
precision = 14
output_buffering = 4096
zlib.output_compression = Off
implicit_flush = Off
serialize_precision = -1
zend.enable_gc = On
zend.exception_ignore_args = On
zend.exception_string_param_max_len = 0
expose_php = Off
max_execution_time = 300
max_input_time = 60
memory_limit = 512M
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE
display_errors = Off
display_startup_errors = Off
log_errors = On
log_errors_max_len = 1024
ignore_repeated_errors = Off
ignore_repeated_source = Off
report_memleaks = On
variables_order = "GPCS"
request_order = "GP"
register_argc_argv = Off
auto_globals_jit = On
post_max_size = 100M
default_mimetype = "text/html"
default_charset = "UTF-8"
enable_dl = Off
file_uploads = On
upload_max_filesize = 100M
max_file_uploads = 20
allow_url_fopen = On
allow_url_include = Off
default_socket_timeout = 60

extension_dir = "ext"
extension=curl
extension=fileinfo
extension=gd
extension=intl
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=zip
extension=soap
extension=sockets

[Date]
date.timezone = "America/Sao_Paulo"

[Pdo_mysql]
pdo_mysql.default_socket=

[mail function]
SMTP = localhost
smtp_port = 25

[MySQLi]
mysqli.max_persistent = -1
mysqli.allow_persistent = On
mysqli.max_links = -1
mysqli.default_port = 3307
mysqli.default_socket =
mysqli.default_host =
mysqli.default_user =
mysqli.default_pw =
mysqli.reconnect = Off

[bcmath]
bcmath.scale = 0

[Session]
session.save_handler = files
session.use_strict_mode = 0
session.use_cookies = 1
session.use_only_cookies = 1
session.name = PHPSESSID
session.auto_start = 0
session.cookie_lifetime = 0
session.cookie_path = /
session.cookie_domain =
session.cookie_httponly =
session.cookie_samesite =
session.serialize_handler = php
session.gc_probability = 1
session.gc_divisor = 1000
session.gc_maxlifetime = 1440
session.cache_limiter = nocache
session.cache_expire = 180
session.use_trans_sid = 0
session.sid_length = 26
session.trans_sid_tags = "a=href,area=href,frame=src,form="
session.sid_bits_per_character = 5
`;
  fs.writeFileSync(path.join(PHP_DIR, 'php.ini'), phpIniContent.trim());
  console.log('[PHP] php.ini criado com sucesso.');
}

async function setupMariaDB() {
  if (fs.existsSync(path.join(MARIADB_DIR, 'bin', 'mysqld.exe'))) {
    console.log('[MariaDB] MariaDB já instalado em ' + MARIADB_DIR);
    return;
  }
  const mariaZip = path.join(TEMP_DIR, 'mariadb.zip');
  const mariaExtractDir = path.join(TEMP_DIR, 'mariadb_extracted');
  await downloadFile(MARIADB_URL, mariaZip);
  extractZip(mariaZip, mariaExtractDir);

  // O zip extrai uma subpasta mariadb-10.6.18-winx64
  const subDirs = fs.readdirSync(mariaExtractDir).filter(f => fs.statSync(path.join(mariaExtractDir, f)).isDirectory());
  const sourceDir = subDirs.length > 0 ? path.join(mariaExtractDir, subDirs[0]) : mariaExtractDir;

  fs.mkdirSync(path.join(MARIADB_DIR, 'bin'), { recursive: true });
  fs.mkdirSync(path.join(MARIADB_DIR, 'share'), { recursive: true });

  console.log('[MariaDB] Copiando binários essenciais...');
  // Copiar arquivos necessários de bin
  const neededBinFiles = [
    'mysqld.exe',
    'mysql.exe',
    'mysqladmin.exe',
    'mariadb-install-db.exe',
    'my_print_defaults.exe'
  ];
  
  const sourceBin = path.join(sourceDir, 'bin');
  fs.readdirSync(sourceBin).forEach(file => {
    if (neededBinFiles.includes(file.toLowerCase()) || file.toLowerCase().endsWith('.dll')) {
      fs.copyFileSync(path.join(sourceBin, file), path.join(MARIADB_DIR, 'bin', file));
    }
  });

  // Copiar share (charsets e mensagens de erro)
  const sourceShare = path.join(sourceDir, 'share');
  if (fs.existsSync(sourceShare)) {
    execSync(`powershell -Command "Copy-Item -Path '${sourceShare}' -Destination '${MARIADB_DIR}' -Recurse -Force"`, { stdio: 'inherit' });
  }

  // Criar my.ini básico
  const myIniContent = `
[mysqld]
port=3307
bind-address=127.0.0.1
default-storage-engine=InnoDB
innodb_buffer_pool_size=64M
innodb_log_file_size=16M
max_connections=50
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
sql_mode=NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES

[client]
port=3307
default-character-set=utf8mb4

[mysql]
port=3307
default-character-set=utf8mb4
`;
  fs.writeFileSync(path.join(MARIADB_DIR, 'my.ini'), myIniContent.trim());
  console.log('[MariaDB] Configuração do MariaDB concluída.');
}

async function setupComposerAndDependencies() {
  const rootDir = path.resolve(DESKTOP_DIR, '..');
  const vendorDir = path.join(rootDir, 'vendor');
  const phpExe = path.join(PHP_DIR, 'php.exe');

  if (fs.existsSync(vendorDir)) {
    console.log('[Composer] vendor/ já existe.');
    return;
  }

  const composerPhar = path.join(TEMP_DIR, 'composer.phar');
  if (!fs.existsSync(composerPhar)) {
    await downloadFile(COMPOSER_URL, composerPhar);
  }

  console.log('[Composer] Instalando dependências do Composer...');
  execSync(`"${phpExe}" "${composerPhar}" install --no-dev --optimize-autoloader --ignore-platform-reqs`, {
    cwd: rootDir,
    stdio: 'inherit'
  });
  console.log('[Composer] Dependências PHP instaladas com sucesso.');
}

async function main() {
  try {
    fs.mkdirSync(TEMP_DIR, { recursive: true });
    fs.mkdirSync(BIN_DIR, { recursive: true });

    await setupPHP();
    await setupMariaDB();
    await setupComposerAndDependencies();

    // Copiar DLLs essenciais do Visual C++ Redistributable caso existam no sistema
    console.log('[Runtime] Verificando e copiando DLLs de runtime C++ (VCRUNTIME/MSVCP)...');
    const system32 = path.join(process.env.SystemRoot || 'C:\\Windows', 'System32');
    const runtimeDlls = ['vcruntime140.dll', 'vcruntime140_1.dll', 'msvcp140.dll'];
    runtimeDlls.forEach(dll => {
      const src = path.join(system32, dll);
      if (fs.existsSync(src)) {
        try {
          fs.copyFileSync(src, path.join(PHP_DIR, dll));
          fs.copyFileSync(src, path.join(MARIADB_DIR, 'bin', dll));
          console.log(`[Runtime] Copiado ${dll} para PHP e MariaDB.`);
        } catch (copyErr) {
          console.warn(`[Runtime] Aviso ao copiar ${dll}: ${copyErr.message}`);
        }
      }
    });

    // Limpar temp_downloads
    console.log('[Clean] Limpando arquivos temporários de download...');
    try {
      fs.rmSync(TEMP_DIR, { recursive: true, force: true });
    } catch (e) {}

    console.log('=== [Sucesso] Todos os binários portáteis foram configurados com sucesso! ===');
  } catch (err) {
    console.error('Erro na preparação dos binários:', err);
    process.exit(1);
  }
}

main();
