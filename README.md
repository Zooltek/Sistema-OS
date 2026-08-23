# Amura OS - Sistema de Gestão de Ordens de Serviço e Vendas

![Amura OS Banner](assets/img/logo-original.png)

O **Amura OS** é um sistema completo e moderno para gestão de Ordens de Serviço (OS), Vendas, Clientes, Produtos, Serviços, Lançamentos Financeiros e Termos de Garantia. Projetado com visual *White Label* para a **Amura Tecnologias**, o sistema oferece tanto execução via Web (Docker) quanto aplicativo desktop nativo para Windows (`.exe` via Electron).

---

## 🚀 Tecnologias Utilizadas

- **Backend**: PHP 8 (Framework CodeIgniter 3)
- **Banco de Dados**: MySQL 8.0 (Codificação `utf8mb4` com suporte total a acentuação e emojis)
- **Servidor Web**: Nginx
- **Ambiente Containerizado**: Docker & Docker Compose
- **Aplicativo Desktop**: Electron + `electron-builder` (Instalador `.exe` nativo para Windows)
- **Frontend & Gráficos**: HTML5, CSS3 (Vanilla + Temas Customizados), Chart.js 3.7 (Gráficos Financeiros em Barras Horizontais)

---

## 🛠️ Como Executar o Amura OS

### 1. Via Aplicativo Desktop (Windows)
Navegue até a pasta `dist/` ou utilize o instalador:
- **Instalador Completo**: Executar `dist/Amura OS Setup 1.0.0.exe`
- **Versão Portátil / Teste Imediato**: Executar [dist/win-unpacked/Amura OS.exe](file:///d:/Projetos/Amura%20OS/dist/win-unpacked/Amura%20OS.exe)

### 2. Via Docker Compose (Servidor / Web local)
Na raiz do projeto (ou dentro da pasta `docker/`):
```bash
docker-compose -f docker/docker-compose.yml up -d
```
Acesse as portas no seu navegador:
- **Amura OS Web**: [http://localhost:8002](http://localhost:8002)
- **phpMyAdmin**: [http://localhost:8082](http://localhost:8082)
- **Porta MySQL**: `8990`

**Credenciais de Acesso Padrão**:
- **Usuário**: `admin@admin.com`
- **Senha**: `admin`

---

## ⚙️ Configurações do Sistema (`/sistema/configurar`)

O módulo de configurações centrais permite personalizar todo o comportamento operacional, visual e financeiro do Amura OS. O acesso é restrito aos usuários com permissão de administrador (`cSistema`).

### 1. Aba **Gerais**
- **Nome do Sistema**: Define a marca exibida em todas as telas, rodapés e e-mails (Padrão: `Amura OS`).
- **Tema do Sistema**: Seleção entre 7 temas visuais (Escuro, Claro/White, Pure Dark, Dark Orange, Dark Violet, White Green, White Black).
- **Registros por Página**: Quantidade de itens exibidos em tabelas (10, 20, 50 ou 100).
- **Visualização em DataTables**: Ativa/desativa tabelas dinâmicas com filtro instantâneo.

### 2. Aba **Financeiro**
- **Controle de baixa retroativa**: Ativa ou desativa a baixa financeira com data retroativa.
- **Controle de edição de OS e Vendas**: Permite ou bloqueia a alteração/exclusão de OS ou Vendas que já foram faturadas ou canceladas.
- **Chave Pix**: Informe a chave Pix para recebimento automático exibida na impressão de Ordens de Serviço e Vendas.
- **Gateways de Pagamento**:
  - **EFI (antiga Gerencianet)**: Ambiente (Sandbox/Produção), `CLIENT_ID`, `CLIENT_SECRET` e dias para vencimento do boleto.
  - **Mercado Pago**: `PUBLIC_KEY`, `ACCESS_TOKEN`, `CLIENT_ID`, `CLIENT_SECRET` e dias de vencimento do boleto.
  - **Asaas**: Ambiente, opção `Notify`, `API_KEY` e vencimento do boleto.

### 3. Aba **Produtos**
- **Controlar Estoque**: Ativa ou desativa a baixa automática de estoque na venda ou faturamento de OS.

### 4. Aba **Notificações**
- **Notificação de OS**: Escolha quem recebe e-mail ao alterar status de OS (*Notificar a Todos*, *Somente Cliente*, *Somente Técnico*, *Somente Emitente* ou *Não Notificar*).
- **Enviar Email Automático**: Ativa o envio imediato de e-mails de acompanhamento.
- **Notificação do WhatsApp**: Editor de mensagens customizadas do WhatsApp utilizando tags dinâmicas:
  - `{CLIENTE_NOME}`, `{NUMERO_OS}`, `{STATUS_OS}`, `{VALOR_OS}`, `{DESCRI_PRODUTOS}`, `{EMITENTE}`, `{TELEFONE_EMITENTE}`, `{OBS_OS}`, `{DEFEITO_OS}`, `{LAUDO_OS}`, `{DATA_FINAL}`, `{DATA_INICIAL}`, `{DATA_GARANTIA}`.

### 5. Aba **OS**
- **Controle de Impressão em 2 Vias**: Habilita a impressão dupla da OS na mesma página.
- **Status Padrão na Listagem**: Marcação de quais status de OS serão exibidos por padrão ao abrir a lista de OS.
- **Imprimir Anexos na A4**: Opção para incluir imagens anexadas ao imprimir a OS em folha A4.

### 6. Aba **API**
- **Ativar acesso à API**: Habilita a API RESTful do sistema.
- **URL da API**: Endpoint oficial (`http://localhost:8002/index.php/api/v1`).
- **Tempo de Expiração**: Validade do token JWT (1 min, 1 hora, 1 dia, 1 semana ou 1 mês).
- **Resetar token JWT**: Gera uma nova chave secreta JWT, deslogando conexões externas ativas.

### 7. Aba **E-mail (SMTP)**
- **Protocolo**: Protocolo de envio (ex: `smtp`).
- **Endereço do Host**: Host do servidor de e-mail (ex: `smtp.gmail.com` ou `mail.seudominio.com.br`).
- **Criptografia**: Seleção entre `tls` ou `ssl`.
- **Porta**: Porta SMTP (ex: `587` para TLS ou `465` para SSL).
- **Usuário e Senha**: Credenciais de autenticação do e-mail remetente.

---

## 💾 Backup do Sistema (`/sistema/backup`)

O backup garante a segurança total das informações cadastradas no Amura OS.

### Como Funciona:
1. Acesse o menu **Configurações -> Backup** (ou clique no botão **Fazer Backup** dentro do modal de banco de dados).
2. O sistema gera automaticamente um arquivo compactado `.zip` contendo o dump completo do banco de dados MySQL com timestamp (`backupDD-MM-YYYY_HH-mm-ss.zip`).
3. O download do arquivo inicia imediatamente no seu navegador/aplicativo.

### 📌 Recomendação de Boas Práticas:
- **Frequência**: Realize backups **diários ou semanais**.
- **Armazenamento**: Guarde uma cópia do arquivo de backup fora do computador local (em um serviço de nuvem como Google Drive, OneDrive ou pendrive).
- **Antes de Atualizações**: NUNCA realize atualizações do sistema ou banco de dados sem antes fazer o backup.

---

## 🔄 Atualização do Sistema e Banco de Dados (`/sistema/configurar` -> Aba Atualizações)

O Amura OS possui rotinas automatizadas para manter o banco de dados e a estrutura do código sempre atualizados.

### 1. Atualização do Banco de Dados (`/sistema/atualizarBanco`)
- **Mecanismo**: Utiliza a biblioteca interna de *Migrations* do CodeIgniter (`application/migrations/`). O sistema consulta a tabela `migrations` no MySQL, identifica migrações pendentes em relação aos arquivos de script e aplica automaticamente as alterações na estrutura de tabelas.
- **Passo a Passo**:
  1. Acesse **Configurações -> Atualizações**.
  2. Clique em **Banco de Dados**.
  3. No modal de confirmação, verifique a mensagem e confirme.
  4. O sistema executará as migrações e exibirá: *"Banco de dados atualizado com sucesso!"*.

### 2. Atualização do Código do Sistema (`/sistema/atualizarSistema`)
- **Mecanismo**: Utiliza a biblioteca `Github_updater` ([github_updater.php](file:///d:/Projetos/Amura%20OS/application/libraries/Github_updater.php)).
- **Integração com o GitHub**: Conecta-se à API REST do repositório `https://github.com/Zooltek/Sistema-OS.git` na branch `main`.
- **Fluxo de Atualização**:
  1. Compara a hash do commit atual (`current_commit` em `application/config/github_updater.php`) com a versão mais recente publicada no repositório.
  2. Baixa o arquivo `.zip` da última versão diretamente do GitHub via cURL.
  3. Extrai e compara a lista de arquivos modificados e removidos.
  4. Atualiza os arquivos no servidor mantendo arquivos ignorados intactos.
  5. Atualiza o código da versão e a hash do commit em arquivo.

> [!WARNING]
> **Atenção ao Atualizar**:
> Antes de executar atualizações do código, certifique-se de salvar uma cópia dos arquivos anexados localizados nos diretórios:
> - `./assets/anexos` (Documentos e fotos anexados às OS)
> - `./assets/arquivos` (Uploads gerais)
