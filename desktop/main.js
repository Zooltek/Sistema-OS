const { app, BrowserWindow, Menu, Tray, nativeImage, ipcMain, shell } = require('electron');
const path = require('path');
const ProcessManager = require('./server/process-manager');

let mainWindow = null;
let splashWindow = null;
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

function createMainWindow() {
  const iconPath = path.join(__dirname, '../assets/img/logo-original.png');
  const appIcon = nativeImage.createFromPath(iconPath);

  mainWindow = new BrowserWindow({
    width: 1366,
    height: 850,
    minWidth: 1024,
    minHeight: 700,
    title: APP_TITLE,
    icon: appIcon,
    show: false,
    autoHideMenuBar: true,
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
      nodeIntegration: false,
      contextIsolation: true,
      webSecurity: false
    }
  });

  // Configurar Menu de Aplicação
  const template = [
    {
      label: 'Arquivo',
      submenu: [
        { label: 'Início', click: () => mainWindow.loadURL(SERVER_URL) },
        { type: 'separator' },
        { label: 'Sair', role: 'quit' }
      ]
    },
    {
      label: 'Exibir',
      submenu: [
        { label: 'Recarregar', role: 'reload' },
        { label: 'Forçar Recarregamento', role: 'forceReload' },
        { type: 'separator' },
        { label: 'Alternar Tela Cheia', role: 'togglefullscreen' },
        { label: 'Zoom In', role: 'zoomIn' },
        { label: 'Zoom Out', role: 'zoomOut' },
        { label: 'Resetar Zoom', role: 'resetZoom' }
      ]
    },
    {
      label: 'Ajuda',
      submenu: [
        {
          label: 'Sobre a Amura OS',
          click: () => {
            const aboutWindow = new BrowserWindow({
              width: 420,
              height: 280,
              title: 'Sobre a Amura OS',
              resizable: false,
              autoHideMenuBar: true,
              parent: mainWindow,
              modal: true
            });
            aboutWindow.loadURL(`data:text/html;charset=utf-8,
              <style>
                body { font-family: sans-serif; background: #1e1e2d; color: #fff; text-align: center; padding: 30px; }
                h2 { color: #ff9204; margin-bottom: 5px; }
                p { font-size: 14px; color: #a2a3b7; line-height: 1.5; }
              </style>
              <h2>Amura OS v1.0.0</h2>
              <p>Sistema Avançado de Gestão de Ordens de Serviço</p>
              <p><b>Desenvolvido por Amura Tecnologias</b></p>
            `);
          }
        }
      ]
    }
  ];

  const menu = Menu.buildFromTemplate(template);
  Menu.setApplicationMenu(menu);

  // Abrir links externos no navegador padrão do sistema
  mainWindow.webContents.setWindowOpenHandler(({ url }) => {
    if (url.startsWith('http://') || url.startsWith('https://')) {
      if (!url.includes('127.0.0.1:8002') && !url.includes('localhost:8002')) {
        shell.openExternal(url);
        return { action: 'deny' };
      }
    }
    return { action: 'allow' };
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

  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createMainWindow();
    }
  });
});

app.on('before-quit', async (e) => {
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
