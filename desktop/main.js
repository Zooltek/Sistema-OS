const { app, BrowserWindow, Menu, Tray, nativeImage, ipcMain, shell, dialog, session } = require('electron');
const path = require('path');
const fs = require('fs');
const ProcessManager = require('./server/process-manager');

let mainWindow = null;
let splashWindow = null;
let manualWindow = null;
let processManager = null;

const SERVER_URL = 'http://127.0.0.1:8002';
const APP_TITLE = 'Amura OS - Sistema de Gestão';

function createSplashWindow() {
  splashWindow = new BrowserWindow({
    width: 520,
    height: 340,
    frame: false,
    transparent: true,
    alwaysOnTop: true,
    center: true,
    resizable: false,
    webPreferences: {
      nodeIntegration: false,
      contextIsolation: true
    }
  });

  splashWindow.loadFile(path.join(__dirname, 'splash.html'));
}

function openManualWindow() {
  if (manualWindow && !manualWindow.isDestroyed()) {
    manualWindow.focus();
    return;
  }

  const iconPath = path.join(__dirname, 'assets/icon.png');
  const appIcon = fs.existsSync(iconPath) ? nativeImage.createFromPath(iconPath) : null;

  manualWindow = new BrowserWindow({
    width: 1100,
    height: 750,
    minWidth: 800,
    minHeight: 550,
    title: 'Manual do Usuário - Amura OS',
    icon: appIcon,
    autoHideMenuBar: true,
    backgroundColor: '#151521',
    webPreferences: {
      nodeIntegration: false,
      contextIsolation: true
    }
  });

  manualWindow.loadFile(path.join(__dirname, 'manual.html'));

  manualWindow.on('closed', () => {
    manualWindow = null;
  });
}

function buildApplicationMenu() {
  const menuTemplate = [
    {
      label: 'Arquivo',
      submenu: [
        {
          label: 'Abrir no Navegador Padrão',
          click: () => {
            shell.openExternal(SERVER_URL);
          }
        },
        {
          label: 'Abrir Pasta de Dados (AppData)',
          click: () => {
            if (processManager && processManager.dataDir) {
              shell.openPath(processManager.dataDir);
            }
          }
        },
        {
          label: 'Ver Arquivo de Log',
          click: () => {
            if (processManager && processManager.logFile) {
              if (fs.existsSync(processManager.logFile)) {
                shell.openPath(processManager.logFile);
              } else {
                dialog.showMessageBox(mainWindow, {
                  type: 'info',
                  title: 'Arquivo de Log',
                  message: 'O arquivo de log ainda não foi criado.',
                  detail: `Caminho esperado: ${processManager.logFile}`
                });
              }
            }
          }
        },
        {
          label: 'Fazer Backup dos Dados (.sql)',
          click: async () => {
            if (!processManager) return;
            try {
              const defaultDate = new Date().toISOString().slice(0, 10);
              const { canceled, filePath } = await dialog.showSaveDialog(mainWindow, {
                title: 'Salvar Backup do Banco de Dados (MariaDB)',
                defaultPath: `backup-amura-os-${defaultDate}.sql`,
                filters: [
                  { name: 'Arquivo SQL', extensions: ['sql'] },
                  { name: 'Todos os Arquivos', extensions: ['*'] }
                ]
              });

              if (!canceled && filePath) {
                const result = await processManager.backupDatabase(filePath);
                dialog.showMessageBox(mainWindow, {
                  type: 'info',
                  title: 'Backup Concluído',
                  message: 'Cópia de segurança salva com sucesso!',
                  detail: `Arquivo salvo em:\n${filePath}\nTamanho: ${result.sizeKb} KB`
                });
              }
            } catch (err) {
              dialog.showErrorBox('Erro no Backup', `Não foi possível gerar a cópia de segurança:\n${err.message}`);
            }
          }
        },
        { type: 'separator' },
        {
          label: 'Sair',
          role: 'quit'
        }
      ]
    },
    {
      label: 'Exibir',
      submenu: [
        {
          label: 'Recarregar',
          accelerator: 'CmdOrCtrl+R',
          click: () => {
            if (mainWindow) mainWindow.loadURL(SERVER_URL);
          }
        },
        {
          label: 'Forçar Recarregamento',
          accelerator: 'CmdOrCtrl+Shift+R',
          click: () => {
            if (mainWindow) mainWindow.webContents.reloadIgnoringCache();
          }
        },
        { type: 'separator' },
        {
          label: 'Alternar Tela Cheia',
          role: 'togglefullscreen',
          accelerator: 'F11'
        },
        {
          label: 'Zoom In',
          role: 'zoomIn'
        },
        {
          label: 'Zoom Out',
          role: 'zoomOut'
        },
        {
          label: 'Resetar Zoom',
          role: 'resetZoom'
        }
      ]
    },
    {
      label: 'Ajuda',
      submenu: [
        {
          label: 'Manual do Usuário',
          click: () => {
            openManualWindow();
          }
        },
        { type: 'separator' },
        {
          label: 'Sobre a Amura OS',
          click: () => {
            dialog.showMessageBox(mainWindow, {
              type: 'info',
              title: 'Sobre a Amura OS',
              message: 'Amura OS - Sistema de Gestão de Ordens de Serviço',
              detail: `Versão: 1.0.1\n` +
                      `Desenvolvido por: Amura Tecnologias\n` +
                      `Servidor Web: PHP 8.2 (127.0.0.1:8002)\n` +
                      `Banco de Dados: MariaDB (127.0.0.1:3307)\n` +
                      `Dados: ${processManager ? processManager.dataDir : 'AmuraOS_Data'}`
            });
          }
        }
      ]
    }
  ];

  return Menu.buildFromTemplate(menuTemplate);
}

function createMainWindow() {
  const iconPath = path.join(__dirname, 'assets/icon.png');
  const appIcon = fs.existsSync(iconPath) ? nativeImage.createFromPath(iconPath) : null;

  mainWindow = new BrowserWindow({
    width: 1366,
    height: 850,
    minWidth: 1024,
    minHeight: 700,
    title: APP_TITLE,
    icon: appIcon,
    show: false,
    autoHideMenuBar: false, // Menu superior sempre visível
    backgroundColor: '#1e1e2d',
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
      nodeIntegration: false,
      contextIsolation: true,
      webSecurity: false,
      plugins: true
    }
  });

  // Configurar Menu de Aplicação sempre visível
  const menu = buildApplicationMenu();
  Menu.setApplicationMenu(menu);

  // Abrir links externos no navegador padrão e links internos/relatórios em janela dedicada
  mainWindow.webContents.setWindowOpenHandler(({ url }) => {
    if (url.startsWith('http://') || url.startsWith('https://')) {
      if (!url.includes('127.0.0.1:8002') && !url.includes('localhost:8002')) {
        shell.openExternal(url);
        return { action: 'deny' };
      }
    }
    return {
      action: 'allow',
      overrideBrowserWindowOptions: {
        width: 1200,
        height: 800,
        minWidth: 900,
        minHeight: 600,
        center: true,
        title: 'Amura OS - Visualização e Impressão',
        autoHideMenuBar: false,
        backgroundColor: '#ffffff',
        webPreferences: {
          plugins: true,
          webSecurity: false
        }
      }
    };
  });

  // BLINDAGEM CONTRA TELA BRANCA:
  // Se falhar o carregamento de qualquer rota (servidor reiniciando ou ocupado),
  // exibe uma interface elegante de reconexão automática com botão de tentar novamente
  mainWindow.webContents.on('did-fail-load', (event, errorCode, errorDescription, validatedURL) => {
    if (errorCode === -3) return; // Abortado intencionalmente por nova navegação

    if (processManager) {
      processManager.log(`Falha de navegação (${errorCode} - ${errorDescription}) em: ${validatedURL}`, 'AVISO');
    }

    const recoveryHtml = `
      <!DOCTYPE html>
      <html lang="pt-BR">
      <head>
        <meta charset="UTF-8">
        <title>Conectando ao Amura OS</title>
        <style>
          * { box-sizing: border-box; margin: 0; padding: 0; }
          body {
            background: #151521;
            color: #f1f1f5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 24px;
          }
          .card {
            background: #1e1e2d;
            border: 1px solid #323248;
            border-radius: 12px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
          }
          .icon { font-size: 46px; margin-bottom: 16px; }
          h2 { color: #ff9204; font-size: 20px; margin-bottom: 12px; font-weight: 600; }
          p { color: #92929f; font-size: 14px; line-height: 1.6; margin-bottom: 26px; }
          .btn-group { display: flex; gap: 12px; justify-content: center; }
          button {
            background: #ff9204;
            color: #fff;
            border: none;
            padding: 11px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
          }
          button:hover { background: #e07f00; }
          .btn-sec {
            background: #27273a;
            color: #d1d1db;
            border: 1px solid #323248;
          }
          .btn-sec:hover { background: #323248; color: #fff; }
        </style>
      </head>
      <body>
        <div class="card">
          <div class="icon">🔄</div>
          <h2>Conectando ao Servidor Local...</h2>
          <p>O servidor interno do Amura OS está processando requisições ou se recuperando. Clique abaixo para restabelecer a conexão imediatamente.</p>
          <div class="btn-group">
            <button onclick="window.location.href='${SERVER_URL}'">Tentar Novamente</button>
            <button class="btn-sec" onclick="window.location.reload()">Recarregar</button>
          </div>
        </div>
      </body>
      </html>
    `;

    mainWindow.loadURL(`data:text/html;charset=utf-8,${encodeURIComponent(recoveryHtml)}`);
  });

  // Título dinâmico da janela
  mainWindow.on('page-title-updated', (e) => {
    e.preventDefault();
    mainWindow.setTitle(APP_TITLE);
  });

  mainWindow.on('closed', () => {
    mainWindow = null;
  });
}

// Inicialização do aplicativo
app.whenReady().then(async () => {
  createSplashWindow();
  createMainWindow();

  processManager = new ProcessManager(app, app.isPackaged);

  try {
    await processManager.start((statusMessage) => {
      if (splashWindow && !splashWindow.isDestroyed() && splashWindow.webContents) {
        splashWindow.webContents.executeJavaScript(`
          const el = document.getElementById('status');
          if (el) el.innerText = '${statusMessage}';
        `).catch(() => {});
      }
    });

    mainWindow.loadURL(SERVER_URL);
    mainWindow.once('ready-to-show', () => {
      if (splashWindow && !splashWindow.isDestroyed()) {
        splashWindow.close();
      }
      mainWindow.show();
      mainWindow.maximize();
    });
  } catch (err) {
    if (splashWindow && !splashWindow.isDestroyed()) {
      splashWindow.close();
    }
    const errWindow = new BrowserWindow({ width: 550, height: 280, title: 'Erro de Inicialização' });
    errWindow.loadURL(`data:text/html;charset=utf-8,
      <style>body { font-family: sans-serif; background: #1e1e2d; color: #fff; padding: 25px; text-align: center; }</style>
      <h3 style="color:#f55776;">Falha ao iniciar os serviços locais</h3>
      <p style="color:#a2a3b7; font-size:13px; margin-top:10px;">${err.message}</p>
    `);
  }

  // Gerenciamento Inteligente de Downloads:
  // Se o download foi disparado a partir de uma janela popup auxiliar (ex: exportação XLS),
  // fecha a janela vazia assim que o download for concluído para não deixar tela branca órfã.
  session.defaultSession.on('will-download', (event, item, webContents) => {
    const win = BrowserWindow.fromWebContents(webContents);
    if (win && win !== mainWindow) {
      item.once('done', () => {
        if (!win.isDestroyed()) {
          win.close();
        }
      });
    }
  });

  app.on('web-contents-created', (event, contents) => {
    contents.setWindowOpenHandler(({ url }) => {
      if (url.startsWith('http://') || url.startsWith('https://')) {
        if (!url.includes('127.0.0.1:8002') && !url.includes('localhost:8002')) {
          shell.openExternal(url);
          return { action: 'deny' };
        }
      }
      return {
        action: 'allow',
        overrideBrowserWindowOptions: {
          width: 1200,
          height: 800,
          minWidth: 900,
          minHeight: 600,
          center: true,
          title: 'Amura OS - Visualização e Impressão',
          autoHideMenuBar: false,
          backgroundColor: '#ffffff',
          webPreferences: {
            plugins: true,
            webSecurity: false
          }
        }
      };
    });
  });

  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createMainWindow();
    }
  });
});

app.on('before-quit', async () => {
  if (processManager) {
    await processManager.stopAll();
  }
});

app.on('window-all-closed', async () => {
  if (processManager) {
    await processManager.stopAll();
  }
  if (process.platform !== 'darwin') {
    app.quit();
  }
});
