# Manual do Usuário - Amura OS

Bem-vindo ao **Manual Oficial do Usuário do Amura OS**, o sistema avançado de gestão de Ordens de Serviço, Vendas, Produtos, Clientes e Controle Financeiro desenvolvido por **Fabricio Castro**.

---

## 📋 Sumário
1. [Acesso e Visão Geral](#1-acesso-e-visão-geral)
2. [Atalhos Rápidos de Teclado](#2-atalhos-rápidos-de-teclado)
3. [Configuração da Empresa (Emitente) e WhatsApp](#3-configuração-da-empresa-emitente-e-whatsapp)
4. [Gestão Operacional (Clientes, Produtos, Serviços e OS)](#4-gestão-operacional)
5. [Agenda & Hub de Operações da Tela Inicial](#5-agenda--hub-de-operações-da-tela-inicial)
6. [Guia Detalhado de Configurações do Sistema](#6-guia-detalhado-de-configurações-do-sistema)
7. [Guia Completo de Backup e Restauração de Dados](#7-guia-completo-de-backup-e-restauração-de-dados)
8. [Portal e Área do Cliente (Modo Desktop e Rede)](#8-portal-e-área-do-cliente-modo-desktop-e-rede)
9. [Guia de Atualização de Banco de Dados e Sistema](#9-guia-de-atualização-de-banco-de-dados-e-sistema)

---

## 1. Acesso e Visão Geral

### Como Acessar:
- **No Aplicativo Desktop (Windows)**: Dê um duplo clique no atalho **Amura OS** na sua Área de Trabalho ou execute o aplicativo.
- **No Navegador Web**: Acesse o endereço [http://localhost:8002](http://localhost:8002).

### 🔑 Credenciais Padrão de Acesso:
- **E-mail**: `admin@admin.com`
- **Senha**: `admin`

> **Dica**: Recomendamos alterar a senha no primeiro acesso através do menu superior de usuário -> *Minha Conta / Alterar Senha*.

### Tela Principal (Dashboard):
Ao fazer login, você verá o Dashboard moderno com:
- **Cards de Atalho Modernos (Glassmorphism)**: 6 cards estilizados com iluminação superior, ícones em vidro fosco e micro-interações no hover:
  1. **Clientes** (`F1` - Azul)
  2. **Produtos** (`F2` - Laranja)
  3. **Serviços** (`F3` - Ciano)
  4. **OS** (`F4` - Rosa)
  5. **Vendas** (`F6` - Verde)
  6. **Lançamentos** (`F7` - Amarelo Dourado)
- **Menu Superior Redesenhado**: Botões de ação arredondados de 38x38px em formato pílula para **Perfil**, **Relatórios** e **Configurações**, com menus flutuantes elegantes.
- **Gráfico "Estatísticas Financeiras"**: Gráfico de totalização de Receitas (verde), Despesas (vermelho) e Saldo (azul) formatados em Reais (R$).
- **Agenda & Operações**: Calendário interativo dinâmico para acompanhamento e reprogramação de compromissos, OS e vencimentos financeiros.

---

## 2. Atalhos Rápidos de Teclado

Para agilizar o atendimento diário, utilize as teclas de atalho a qualquer momento no sistema:
- `F1`: Acessar lista de Clientes
- `F2`: Acessar lista de Produtos
- `F3`: Acessar lista de Serviços
- `F4`: Acessar lista de Ordens de Serviço (OS)
- `F6`: Acessar lista de Vendas
- `F7`: Acessar lista de Lançamentos Financeiros
- `ESC`: Voltar para a tela inicial (Dashboard)

---

## 3. Configuração da Empresa (Emitente) e WhatsApp

Antes de emitir OS ou Vendas, configure os dados da sua empresa:
1. Acesse o menu **Configurações (engrenagem) -> Emitente** (`/sistema/emitente`).
2. Preencha a Razão Social, CNPJ, Inscrição Estadual, Endereço completo, Telefone e E-mail de contato.
3. **Telefone / WhatsApp**: O número informado neste campo é utilizado pelo Amura OS para o envio de mensagens pelo WhatsApp (tanto na tag `{TELEFONE_EMITENTE}` quanto na identificação corporativa).
4. Clique em **Alterar Logotipo** para enviar a imagem da sua marca. Essa logomarca e os dados da empresa serão impressos no cabeçalho de todas as OS, Vendas e Termos de Garantia.

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

## 5. Agenda & Hub de Operações da Tela Inicial

A Agenda da tela inicial do Amura OS foi transformada em uma central completa de produtividade:

### ⚡ Funções Integradas:
1. **Compromissos e Lembretes Rápidos**:
   - Clique no botão **"+ Novo Compromisso"** no canto superior da Agenda ou dê um clique duplo em uma data.
   - O modal abre perfeitamente centralizado na tela, com campos de Data e Hora organizados lado a lado, layout compacto e eliminação completa de barras de rolagem (scroll).
   - Defina o título, data, horário, cor de destaque (Laranja, Azul, Verde, Vermelho ou Roxo) e observações.
2. **Criação de OS em 1 Clique**:
   - Ao clicar sobre qualquer dia do calendário, o sistema abre um menu com opções rápidas. Ao escolher **"Abrir Nova Ordem de Serviço"**, o formulário de abertura de OS já carrega a data de entrega pré-selecionada.
3. **Reprogramação de Prazos por Arraste (Drag & Drop)**:
   - Arraste qualquer card de OS ou Compromisso para outro dia. O sistema pede confirmação rápida e atualiza o prazo automaticamente no banco de dados.
4. **Vencimentos Financeiros na Agenda**:
   - As contas a pagar (vermelho) e a receber (verde) do módulo financeiro são plotadas no dia do vencimento com seus respectivos valores e status.
5. **Filtros Avançados**:
   - Alterne a exibição entre:
     - **Todos os Eventos** (OS, Financeiro e Compromissos)
     - **Apenas OS** (com filtro adicional por status: Aberto, Em Andamento, etc.)
     - **Vencimentos (Contas)**
     - **Compromissos**

---

## 6. Guia Detalhado de Configurações do Sistema

Acesse o menu **Configurações -> Sistema** (`/sistema/configurar`). O módulo está estruturado em 9 abas dedicadas:

```
[ Gerais ] [ Financeiro ] [ Produtos ] [ Notificações ] [ Backup ] [ Atualizações ] [ OS ] [ API ] [ E-mail ]
```

### 📍 6.1. Aba Gerais
- Nome do Sistema, Tema visual e Registros por página.

### 📍 6.2. Aba Financeiro
- Baixa retroativa, bloqueio de edição/exclusão após faturamento, Chave Pix e credenciais de gateways (Asaas, Mercado Pago, EFI/Gerencianet).

### 📍 6.3. Aba Produtos
- Controle e baixa automática de estoque.

### 📍 6.4. Aba Notificações (WhatsApp e E-mail)
- Personalização do modelo de mensagem automática do WhatsApp com tags dinâmicas (`{CLIENTE_NOME}`, `{NUMERO_OS}`, `{STATUS_OS}`, `{VALOR_OS}`, `{TELEFONE_EMITENTE}`).

### 📍 6.5. Aba Backup (Nova)
- Painel exclusivo para geração de cópias de segurança (.zip) e restauração (.sql ou .zip).

### 📍 6.6. Aba Atualizações
- Instalação de pacotes de atualização (.zip sem recompilar), migrações manuais de banco e sincronização.

### 📍 6.7. Aba OS
- Impressão em 2 vias e status de visualização padrão.

### 📍 6.8. Aba API
- **Ativar acesso à API**: Ativa ou desativa globalmente os endpoints da API RESTful (`/api/v1/`) para integração externa.
- **URL Base**: Exibe o endpoint base da API do sistema para configuração em aplicativos mobile ou parceiros.
- **Tempo de Expiração**: Define a validade do Token JWT emitido no login (1 minuto a 1 mês).
- **Resetar Token JWT**: Gera uma nova chave secreta criptográfica (`JWT_SECRET`), revogando imediatamente todos os tokens JWT antigos para segurança.

### 📍 6.9. Aba E-mail
- Configuração de servidor SMTP para envio de e-mails automáticos.

---

## 7. Guia Completo de Backup e Restauração de Dados

O backup é a única garantia de que suas informações estarão a salvo em caso de falha de hardware ou imprevistos.

### 🔄 Como Fazer o Backup:
1. Acesse **Configurações -> Sistema**.
2. Clique na aba **Backup**.
3. Clique em **Fazer Download do Backup (.zip)**.
4. O sistema gerará um arquivo compactado contendo toda a base de dados.

### 📥 Como Restaurar um Backup:
1. Na mesma aba **Backup**, localize o card **Restaurar Cópia de Segurança**.
2. Selecione o arquivo `.sql` ou `.zip` desejado.
3. Clique em **Restaurar Backup** e confirme o aviso de segurança.

> **Importante**: No menu nativo do Electron da janela desktop (**Arquivo -> Fazer Backup dos Dados**), também é possível salvar cópias de segurança diretas em formato `.sql`.

---

## 8. Portal e Área do Cliente (Modo Desktop e Rede)

O Amura OS conta com um portal exclusivo para que os clientes acompanhem ordens de serviço, faturas e garantias (`/mine`).

### Visual Renovado:
- Tela de login corporativa moderna com a logo clara da Amura, imagem hero de destaque, layout responsivo em duas colunas e alternador de visualização de senha.

### Como Disponibilizar o Acesso pelo Modo Desktop:
1. **Na mesma rede (Loja / Oficina)**:
   - Na janela do Amura OS, acesse o menu **Rede Local -> Compartilhar na Rede Local (Ligar / Desligar)**.
   - Veja o endereço em **Rede Local -> Ver Endereços de Acesso (IP / URL)** (ex: `http://192.168.1.100:8002/mine`).
   - Qualquer computador, tablet ou celular conectado ao mesmo Wi-Fi poderá acessar o portal.
2. **Pela Internet (Cliente acessando de casa)**:
   - Como o Amura OS Desktop roda em seu computador local, para liberar o acesso externo recomenda-se utilizar uma ferramenta de túnel seguro e gratuito como **Cloudflare Tunnel (cloudflared)** ou **Ngrok**, criando uma URL pública (ex: `https://clientes.suaempresa.com.br/mine`) apontando para a porta `8002`.

---

## 9. Guia de Atualização de Banco de Dados e Sistema

- **Pacotes Hot-Update (Modulares)**: Atualizações pontuais do sistema podem ser geradas via comando `npm run hot-update` no terminal, empacotando automaticamente os arquivos modificados em `.zip` na pasta `updates/hot-updates/`.
- **Instalação do Pacote no Amura OS Desktop**: No aplicativo Desktop, acesse o menu superior **Arquivo -> Instalar Pacote de Atualização (.zip)...** e selecione o arquivo. O sistema cria backup preventivo do banco, aplica os arquivos e recarrega instantaneamente.
- **Pacotes via Painel Web**: Também é possível enviar pacotes diretamente pela aba **Configurações -> Atualizações**.
- **Migrações de Banco de Dados**: Clique em **Executar Migrações do Banco** para atualizar schemas e tabelas.

---

*Manual atualizado por Fabricio Castro.*
