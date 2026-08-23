const { app, BrowserWindow, Menu, Tray, nativeImage, ipcMain, shell } = require('electron');
const path = require('path');
const http = require('http');

let mainWindow = null;
let splashWindow = null;
let tray = null;

const SERVER_URL = 'http://localhost:8002';
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
      if (!url.includes('localhost:8002')) {
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

  // Travar fechamento na bandeja (Tray) ou sair
  mainWindow.on('closed', () => {
    mainWindow = null;
  });
}

function checkServerAndLoad(retryCount = 0) {
  http.get(SERVER_URL, (res) => {
    if (res.statusCode >= 200 && res.statusCode < 400) {
      mainWindow.loadURL(SERVER_URL);
      mainWindow.once('ready-to-show', () => {
        if (splashWindow && !splashWindow.isDestroyed()) {
          splashWindow.close();
        }
        mainWindow.show();
        mainWindow.maximize();
      });
    } else {
      retryServerCheck(retryCount);
    }
  }).on('error', () => {
    retryServerCheck(retryCount);
  });
}

function retryServerCheck(retryCount) {
  if (retryCount > 60) {
    if (splashWindow && !splashWindow.isDestroyed()) {
      splashWindow.close();
    }
    const errWindow = new BrowserWindow({ width: 500, height: 260, title: 'Erro de Conexão' });
    errWindow.loadURL(`data:text/html;charset=utf-8,
      <style>body { font-family: sans-serif; background: #1e1e2d; color: #fff; padding: 25px; text-align: center; }</style>
      <h3 style="color:#f55776;">Não foi possível conectar ao servidor local (port 8002)</h3>
      <p>Certifique-se de que os containers do Amura OS estão em execução.</p>
    `);
    return;
  }
  setTimeout(() => checkServerAndLoad(retryCount + 1), 1000);
}

app.whenReady().then(() => {
  createSplashWindow();
  createMainWindow();
  checkServerAndLoad();

  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createMainWindow();
    }
  });
});

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});
