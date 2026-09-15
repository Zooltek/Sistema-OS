const { contextBridge, ipcRenderer } = require('electron');

contextBridge.exposeInMainWorld('electronAPI', {
  appVersion: '1.0.1',
  isElectron: true,
  sendMessage: (channel, data) => {
    ipcRenderer.send(channel, data);
  }
});
