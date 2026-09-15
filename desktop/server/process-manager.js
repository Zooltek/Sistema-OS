const { spawn, exec, execSync } = require('child_process');
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
    if (isPortable) {
      this.dataDir = path.join(process.env.PORTABLE_EXECUTABLE_DIR, 'AmuraOS_Data');
    } else if (this.isPackaged) {
      this.dataDir = path.join(this.app.getPath('userData'), 'AmuraOS_Data');
    } else {
      this.dataDir = path.join(this.appRoot, 'data_local');
    }

    this.dbDataDir = path.join(this.dataDir, 'db');
    this.logsDir = path.join(this.dataDir, 'logs');
    this.logFile = path.join(this.logsDir, 'app_debug.log');
    this.phpErrorLog = path.join(this.logsDir, 'php_error.log');

    this.mysqlProcess = null;
    this.phpProcess = null;
    this.isShuttingDown = false;
    this.phpRestartTimeout = null;

    // Criar diretórios necessários
    try {
      if (!fs.existsSync(this.dataDir)) fs.mkdirSync(this.dataDir, { recursive: true });
      if (!fs.existsSync(this.dbDataDir)) fs.mkdirSync(this.dbDataDir, { recursive: true });
      if (!fs.existsSync(this.logsDir)) fs.mkdirSync(this.logsDir, { recursive: true });
    } catch (err) {
      console.error('Erro ao criar pastas de dados/logs:', err);
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
      const installCmd = `"${this.installDbExe}" --datadir="${cleanDbPath}"`;
      try {
        execSync(installCmd, { stdio: 'inherit' });
        this.log('Banco de dados inicializado com sucesso.');
      } catch (err) {
        this.log(`Aviso na inicialização do banco: ${err.message}`, 'AVISO');
      }
    }
  }

  async startMariaDB() {
    return new Promise((resolve) => {
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

      const finish = () => {
        if (!isResolved) {
          isResolved = true;
          clearInterval(checkPing);
          resolve();
        }
      };

      this.mysqlProcess.on('error', (err) => {
        this.log(`Erro no processo MariaDB: ${err.message}`, 'ERRO');
        finish();
      });

      const checkPing = setInterval(() => {
        attempts++;
        exec(`"${this.mysqladminExe}" -h 127.0.0.1 -P 3307 -u root ping`, (err, stdout) => {
          if (!err && stdout && stdout.includes('alive')) {
            this.log('MariaDB está pronto e respondendo (alive).');
            finish();
          } else if (attempts >= 60) {
            this.log('Atingiu limite de tentativas para MariaDB ping.', 'AVISO');
            finish();
          }
        });
      }, 150);
    });
  }

  async importInitialSchemaIfNeeded(onProgress) {
    return new Promise((resolve) => {
      const checkDbCmd = `"${this.mysqlExe}" -h 127.0.0.1 -P 3307 -u root -e "SHOW DATABASES LIKE 'amura_os';"`;
      exec(checkDbCmd, (err, stdout) => {
        if (!stdout || !stdout.includes('amura_os')) {
          if (onProgress) onProgress('Criando banco e importando dados iniciais...');
          this.log('Banco amura_os não encontrado. Criando e importando banco.sql...');
          
          try {
            execSync(`"${this.mysqlExe}" -h 127.0.0.1 -P 3307 -u root -e "CREATE DATABASE IF NOT EXISTS amura_os CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"`);
            if (fs.existsSync(this.bancoSql)) {
              execSync(`powershell -Command "Get-Content -Path '${this.bancoSql}' -Raw | & '${this.mysqlExe}' -h 127.0.0.1 -P 3307 -u root amura_os"`, { stdio: 'inherit' });
              this.log('banco.sql importado com sucesso!');
            }
          } catch (importErr) {
            this.log(`Erro na importação: ${importErr.message}`, 'ERRO');
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
          execSync(`"${this.mysqlExe}" -h 127.0.0.1 -P 3307 -u root -e "${fixUserSql.replace(/\r?\n/g, ' ')}"`, { stdio: 'ignore' });
        } catch (sanityErr) {
          this.log(`Aviso ao verificar credenciais de usuário: ${sanityErr.message}`, 'AVISO');
        }

        resolve();
      });
    });
  }

  async startPhpServer() {
    if (this.isShuttingDown) return;

    this.log('Iniciando servidor PHP embutido...');
    const env = Object.assign({}, process.env, {
      DB_HOSTNAME: '127.0.0.1',
      DB_PORT: '3307',
      DB_USERNAME: 'root',
      DB_PASSWORD: '',
      DB_DATABASE: 'amura_os',
      DB_DRIVER: 'mysqli',
      APP_BASEURL: 'http://localhost:8002/'
    });

    const cleanPhpErrorLog = this.phpErrorLog.replace(/\\/g, '/');

    const args = [
      '-S', '127.0.0.1:8002',
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
      const interval = setInterval(() => {
        elapsed += 0.15;
        http.get(url, (res) => {
          if (res.statusCode >= 200 && res.statusCode < 500) {
            clearInterval(interval);
            this.log(`Servidor web respondeu com status ${res.statusCode}.`);
            resolve();
          }
        }).on('error', () => {
          if (elapsed >= maxSeconds) {
            clearInterval(interval);
            reject(new Error('Tempo limite excedido aguardando servidor web local.'));
          }
        });
      }, 150);
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

  async stopAll() {
    if (this.isShuttingDown) return;
    this.isShuttingDown = true;
    clearTimeout(this.phpRestartTimeout);
    this.log('Encerrando serviços de suporte (PHP e MariaDB)...');

    if (this.phpProcess) {
      try {
        this.phpProcess.kill();
        exec(`taskkill /PID ${this.phpProcess.pid} /T /F`, () => {});
      } catch (e) {}
    }

    if (this.mysqlProcess) {
      try {
        execSync(`"${this.mysqladminExe}" -h 127.0.0.1 -P 3307 -u root shutdown`, { stdio: 'ignore' });
      } catch (e) {
        try {
          this.mysqlProcess.kill();
          exec(`taskkill /PID ${this.mysqlProcess.pid} /T /F`, () => {});
        } catch (err) {}
      }
    }
  }
}

module.exports = ProcessManager;
