# Manual do Usuário - Amura OS

Bem-vindo ao **Manual Oficial do Usuário do Amura OS**, o sistema avançado de gestão de Ordens de Serviço, Vendas, Produtos, Clientes e Controle Financeiro da **Amura Tecnologias**.

---

## 📋 Sumário
1. [Acesso e Visão Geral](#1-acesso-e-visão-geral)
2. [Atalhos Rápidos de Teclado](#2-atalhos-rápidos-de-teclado)
3. [Configuração da Empresa (Emitente)](#3-configuração-da-empresa-emitente)
4. [Gestão Operacional (Clientes, Produtos, Serviços e OS)](#4-gestão-operacional)
5. [Guia Detalhado de Configurações do Sistema](#5-guia-detalhado-de-configurações-do-sistema)
6. [Guia Completo de Backup de Dados](#6-guia-completo-de-backup-de-dados)
7. [Guia de Atualização de Banco de Dados e Sistema](#7-guia-de-atualização-de-banco-de-dados-e-sistema)

---

## 1. Acesso e Visão Geral

### Como Acessar:
- **No Aplicativo Desktop (Windows)**: Dê um duplo clique no atalho **Amura OS** na sua Área de Trabalho ou execute `Amura OS Setup 1.0.0.exe`.
- **No Navegador Web**: Acesse o endereço [http://localhost:8002](http://localhost:8002).

### 🔑 Credenciais Padrão de Acesso:
- **E-mail**: `admin@admin.com`
- **Senha**: `admin`

> **Dica**: Recomendamos alterar a senha no primeiro acesso através do menu superior de usuário -> *Minha Conta / Alterar Senha*.

### Tela Principal (Dashboard):
Ao fazer login, você verá o Dashboard com:
- **Cards Superiores**: Resumo de Clientes, Produtos, Serviços, Lançamentos Financeiros e OS.
- **Gráfico "Estatísticas Financeiras"**: Gráfico de Barras Horizontais com totalização de Receitas (verde), Despesas (vermelho) e Saldo (azul) formatados em Reais (R$).
- **Agenda de Eventos e Ordens de Serviço Recentes**: Acompanhamento rápido das atividades do dia.

---

## 2. Atalhos Rápidos de Teclado

Para agilizar o atendimento, utilize as teclas de atalho a qualquer momento no sistema:
- `F1`: Abrir tela de pesquisa geral
- `F2`: Cadastrar novo Cliente
- `F3`: Cadastrar nova Ordem de Serviço (OS)
- `F4`: Cadastrar nova Venda
- `F6`: Acessar lista de Clientes
- `F7`: Acessar lista de Ordens de Serviço

---

## 3. Configuração da Empresa (Emitente)

Antes de emitir OS ou Vendas, configure os dados da sua empresa:
1. Acesse o menu **Configurações -> Emitente** (`/sistema/emitente`).
2. Preencha a Razão Social, CNPJ, Inscrição Estadual, Endereço completo, Telefone e E-mail de contato.
3. Clique em **Alterar Logotipo** para enviar a imagem da sua marca (recomendado 130x130px).
4. Essa logomarca e os dados da empresa serão impressos no cabeçalho de todas as OS, Vendas e Termos de Garantia.

---

## 4. Gestão Operacional

### Ordens de Serviço (OS):
- Acesse **OS -> Adicionar OS**.
- Selecione o Cliente, informe o Equipamento, Defeito Relatado e Laudo Técnico.
- Adicione os Produtos e Serviços utilizados. O sistema calcula automaticamente o valor total.
- **Faturamento**: Clique em **Faturar OS** para gerar o recebimento financeiro automático no caixa e dar baixa nos produtos do estoque.

### Vendas:
- Acesse **Vendas -> Adicionar Venda**.
- Adicione os produtos comprados, aplique desconto se necessário e clique em **Faturar Venda**.

---

## 5. Guia Detalhado de Configurações do Sistema

Acesse o menu **Configurações -> Sistema** (`/sistema/configurar`). O módulo de configurações está dividido em 8 abas funcionais:

```
[ Gerais ] [ Financeiro ] [ Produtos ] [ Notificações ] [ Atualizações ] [ OS ] [ API ] [ E-mail ]
```

### 📍 5.1. Aba Gerais
- **Nome do Sistema**: Nome que aparece no topo, navegador e e-mails (Padrão: `Amura OS`).
- **Tema do Sistema**: Alterne entre 7 temas visuais (Dark, White, Pure Dark, Dark Orange, Dark Violet, White Green, White Black).
- **Registros por Página**: Quantidade de registros por tabela (10, 20, 50, 100).

### 📍 5.2. Aba Financeiro
- **Permitir Baixa Retroativa**: Habilita o registro de pagamentos com datas passadas.
- **Edição/Exclusão de OS/Vendas Faturadas**: Quando desativado, impede que funcionários alterem ou apaguem OS ou Vendas que já geraram entrada financeira.
- **Chave Pix**: Digite sua chave Pix (CPF, CNPJ, E-mail, Celular ou Aleatória). Ela será impressa automaticamente nas OS e Vendas para o cliente pagar via QR Code / Pix copia e cola.
- **Configuração de Gateways de Pagamento**:
  - **EFI / Gerencianet**: Insira `CLIENT_ID` e `CLIENT_SECRET` para geração automática de Boletos e Pix cobrança.
  - **Mercado Pago**: Insira `PUBLIC_KEY` e `ACCESS_TOKEN`.
  - **Asaas**: Insira a `API_KEY` da sua conta Asaas.

### 📍 5.3. Aba Produtos
- **Controlar Estoque**: Quando **Sim**, diminui a quantidade de produtos disponíveis sempre que uma venda ou OS for faturada.

### 📍 5.4. Aba Notificações (WhatsApp e E-mail)
- **Notificação de OS por E-mail**: Selecione os destinatários (*Todos, Cliente, Técnico, Emitente ou Nenhum*).
- **Mensagem do WhatsApp**: Personalize o modelo do texto enviado ao cliente via WhatsApp. Você pode utilizar as seguintes tags automáticas:
  - `{CLIENTE_NOME}`: Nome completo do cliente.
  - `{NUMERO_OS}`: Número identificador da OS.
  - `{STATUS_OS}`: Status atual (ex: Em Andamento, Orçamento, Finalizado).
  - `{VALOR_OS}`: Valor total da OS em R$.
  - `{DESCRI_PRODUTOS}`: Resumo dos serviços e produtos.
  - `{EMITENTE}`: Nome da sua empresa.

### 📍 5.5. Aba OS
- **Impressão em 2 Vias**: Define se a OS será impressa em 2 vias na mesma folha A4.
- **Status Padrão**: Escolha quais status de OS aparecem automaticamente na listagem principal.

### 📍 5.6. Aba API
- **Ativar API REST**: Permite integrar o Amura OS com aplicativos externos ou sistemas de terceiros.
- **Endpoint da API**: `http://localhost:8002/index.php/api/v1`
- **Tempo do Token**: Validade do token JWT de autenticação.
- **Botão "Resetar Token JWT"**: Clique para revogar todos os acessos externos ativos imediatamente.

### 5.7. Aba E-mail (SMTP)
- Configure os dados do seu servidor de e-mail para envio de notificações automáticas (Host, Porta, Criptografia TLS/SSL, Usuário e Senha).

---

## 6. Guia Completo de Backup de Dados

O backup é a única garantia de que suas informações estarão a salvo em caso de falha de hardware ou imprevistos.

### 🔄 Como Fazer o Backup em 1 Clique:
1. Clique no menu superior **Configurações -> Backup** (ou acesse a URL `/sistema/backup`).
2. O sistema gerará e baixará um arquivo `.zip` contendo toda a base de dados MySQL (ex: `backup23-08-2026_18-00-00.zip`).

### 🛡️ Plano Recomendado de Segurança:
- **Rotina de Backup**: Faça backup ao final de cada dia de trabalho ou semanalmente.
- **Armazenamento Seguro**: Salve o arquivo `.zip` em um pendrive ou pasta sincronizada na nuvem (Google Drive, Dropbox, OneDrive).
- **Ressuprimento de Imagens**: Além do arquivo `.zip` do banco de dados, faça periodicamente uma cópia das pastas de anexos:
  - `d:\Projetos\Amura OS\assets\anexos`
  - `d:\Projetos\Amura OS\assets\arquivos`

---

## 7. Guia de Atualização de Banco de Dados e Sistema

Mantenha seu sistema seguro e com os últimos recursos instalados.

### 🗄️ Atualizando a Estrutura do Banco de Dados (`/sistema/atualizarBanco`)
Quando houver atualizações que alterem colunas ou criem novas tabelas no banco de dados:
1. Acesse **Configurações -> Atualizações**.
2. Clique no botão **Banco de Dados**.
3. Confirme a execução no aviso que aparecerá na tela.
4. O Amura OS executará as *migrations* internas automaticamente e exibirá a mensagem de sucesso.

### 💻 Atualizando o Código do Sistema (`/sistema/atualizarSistema`)
1. Antes de atualizar, **FAÇA UM BACKUP DO BANCO DE DADOS** (conforme a Seção 6).
2. Acesse **Configurações -> Atualizações**.
3. Clique no botão **Atualizar Amura OS**.
4. O sistema irá sincronizar e atualizar os arquivos da aplicação.

---

*Manual elaborado pela equipe de desenvolvimento Amura Tecnologias.*
