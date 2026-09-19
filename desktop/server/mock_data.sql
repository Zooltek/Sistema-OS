-- Mock Data para Amura OS
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Emitente
INSERT INTO `emitente` (`id`, `nome`, `cnpj`, `ie`, `rua`, `numero`, `bairro`, `cidade`, `uf`, `telefone`, `email`, `url_logo`, `cep`) VALUES
(1, 'Amura Tecnologia e Soluções Ltda', '12.345.678/0001-90', '123.456.789.111', 'Av. Paulista', '1578', 'Bela Vista', 'São Paulo', 'SP', '(11) 3254-8800', 'contato@amura.com.br', 'assets/img/logo-mapos.png', '01310-200')
ON DUPLICATE KEY UPDATE `nome` = VALUES(`nome`), `cnpj` = VALUES(`cnpj`), `telefone` = VALUES(`telefone`), `email` = VALUES(`email`);

-- 2. Categorias
INSERT INTO `categorias` (`idCategorias`, `categoria`, `cadastro`, `status`, `tipo`) VALUES
(1, 'Manutenção e Reparo', '2026-01-10', 1, 'Serviços'),
(2, 'Venda de Hardwares e Peças', '2026-01-10', 1, 'Produtos'),
(3, 'Serviços de Rede e Servidores', '2026-01-10', 1, 'Serviços'),
(4, 'Receita Operacional', '2026-01-10', 1, 'Receita'),
(5, 'Despesas Administrativas', '2026-01-10', 1, 'Despesa')
ON DUPLICATE KEY UPDATE `categoria` = VALUES(`categoria`);

-- 3. Contas Financeiras
INSERT INTO `contas` (`idContas`, `conta`, `banco`, `numero`, `saldo`, `cadastro`, `status`, `tipo`) VALUES
(1, 'Conta Corrente Principal', 'Banco Itaú', '12345-6', 28500.00, '2026-01-01', 1, 'Conta Corrente'),
(2, 'Caixa Operacional Balcão', 'Caixa Interno', '0001', 3420.50, '2026-01-01', 1, 'Caixa Físico')
ON DUPLICATE KEY UPDATE `conta` = VALUES(`conta`), `saldo` = VALUES(`saldo`);

-- 4. Clientes
INSERT INTO `clientes` (`idClientes`, `asaas_id`, `nomeCliente`, `sexo`, `pessoa_fisica`, `documento`, `telefone`, `celular`, `email`, `senha`, `dataCadastro`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`, `contato`, `complemento`, `fornecedor`) VALUES
(1, NULL, 'Carlos Alberto Medeiros', 'M', 1, '321.654.987-00', '(11) 3456-7890', '(11) 98765-4321', 'carlos.medeiros@gmail.com', '$2y$10$m/ST/CNtsHa63neTDTLMIOkadWFOpTdn.9p5jPOwnvLeZ96DB.pOi', '2026-01-15', 'Rua das Flores', '350', 'Jardins', 'São Paulo', 'SP', '01415-000', 'Carlos', 'Apto 42', 0),
(2, NULL, 'Mariana Vasconcelos Guimarães', 'F', 1, '987.123.456-11', '(11) 3122-4455', '(11) 99887-1122', 'mariana.vasconcelos@outlook.com', '$2y$10$m/ST/CNtsHa63neTDTLMIOkadWFOpTdn.9p5jPOwnvLeZ96DB.pOi', '2026-02-01', 'Av. Brasil', '1200', 'Jardim América', 'São Paulo', 'SP', '01430-000', 'Mariana', 'Sala 3', 0),
(3, NULL, 'TechLog Logística Integrada Eireli', 'M', 0, '18.992.341/0001-45', '(11) 4004-9988', '(11) 97654-3210', 'financeiro@techlog.com.br', '$2y$10$m/ST/CNtsHa63neTDTLMIOkadWFOpTdn.9p5jPOwnvLeZ96DB.pOi', '2026-02-10', 'Rodovia Anhanguera', 'Km 18', 'Distrito Industrial', 'Osasco', 'SP', '06276-000', 'Eng. Roberto', 'Galpão 4', 0),
(4, NULL, 'Distribuidora Global Tech Brasil', 'M', 0, '05.882.119/0001-80', '(11) 3322-1100', '(11) 98111-2233', 'vendas@globaltech.com.br', '$2y$10$m/ST/CNtsHa63neTDTLMIOkadWFOpTdn.9p5jPOwnvLeZ96DB.pOi', '2026-01-05', 'Rua Santa Ifigênia', '520', 'República', 'São Paulo', 'SP', '01207-000', 'Marcos Santos', 'Andar 2', 1)
ON DUPLICATE KEY UPDATE `nomeCliente` = VALUES(`nomeCliente`), `documento` = VALUES(`documento`);

-- 5. Produtos
INSERT INTO `produtos` (`idProdutos`, `codDeBarra`, `descricao`, `unidade`, `precoCompra`, `precoVenda`, `estoque`, `estoqueMinimo`, `saida`, `entrada`) VALUES
(1, '7891000123451', 'SSD NVMe Kingston NV2 1TB PCIe 4.0 M.2', 'UNID', 280.00, 480.00, 24, 5, 1, 1),
(2, '7891000123452', 'Memória RAM Corsair DDR4 16GB 3200MHz', 'UNID', 160.00, 290.00, 32, 8, 1, 1),
(3, '7891000123453', 'Fonte ATX Corsair 650W 80 Plus Bronze', 'UNID', 240.00, 420.00, 14, 4, 1, 1),
(4, '7891000123454', 'Pasta Térmica Arctic MX-4 4g', 'UNID', 30.00, 65.00, 45, 10, 1, 1),
(5, '7891000123455', 'Gabinete Gamer Torre Média 3 Coolers', 'UNID', 190.00, 350.00, 8, 3, 1, 1),
(6, '7891000123456', 'Switch Gigabit 16 Portas TP-Link', 'UNID', 320.00, 580.00, 6, 2, 1, 1)
ON DUPLICATE KEY UPDATE `descricao` = VALUES(`descricao`), `precoVenda` = VALUES(`precoVenda`), `estoque` = VALUES(`estoque`);

-- 6. Serviços
INSERT INTO `servicos` (`idServicos`, `nome`, `descricao`, `preco`) VALUES
(1, 'Diagnóstico Técnico Avançado', 'Análise de hardware e placas', 120.00),
(2, 'Formatação e Otimização', 'Instalação de SO e backup', 180.00),
(3, 'Limpeza Preventiva Geral', 'Higienização e pasta térmica', 150.00),
(4, 'Recuperação de Dados SSD', 'Extração de arquivos', 450.00),
(5, 'Configuração de Rede', 'Cabeamento Cat6 e switches', 380.00)
ON DUPLICATE KEY UPDATE `nome` = VALUES(`nome`), `preco` = VALUES(`preco`);

-- 7. Ordens de Serviço (OS)
INSERT INTO `os` (`idOs`, `dataInicial`, `dataFinal`, `garantia`, `descricaoProduto`, `defeito`, `status`, `observacoes`, `laudoTecnico`, `valorTotal`, `desconto`, `valor_desconto`, `tipo_desconto`, `clientes_id`, `usuarios_id`, `lancamento`, `faturado`, `garantias_id`) VALUES
(1, '2026-03-01', '2026-03-03', '90 dias', 'Notebook Dell Inspiron 15 i7 16GB', 'Lentidão severa ao iniciar e tela azul ocasional', 'Finalizado', 'Equipamento entregue revisado e com selo de garantia', 'Substituição de HD antigo por SSD NVMe 1TB e reinstalação limpa do Windows 11 PRO.', 660.00, 0.00, 660.00, 'real', 1, 1, NULL, 1, NULL),
(2, '2026-03-10', '2026-03-12', '90 dias', 'Workstation Gamer Core i9 RTX 3080', 'Aquecimento excessivo e desligando em render', 'Em Andamento', 'Aguardando teste de estresse térmico de 24h', 'Pasta térmica ressecada e poeira nos coolers. Efetuada limpeza completa e aplicação de pasta Arctic MX-4.', 215.00, 0.00, 215.00, 'real', 2, 1, NULL, 0, NULL),
(3, '2026-03-15', '2026-03-18', '180 dias', 'Servidor de Arquivos Dell PowerEdge T140', 'Alerta de falha no disco RAID 1 e queda na rede', 'Aberto', 'Equipamento crítico da empresa TechLog', 'Análise preliminar indica necessidade de substituição de disco enterprise e reconfiguração do array RAID.', 1160.00, 0.00, 1160.00, 'real', 3, 1, NULL, 0, NULL),
(4, '2026-03-18', '2026-03-20', '90 dias', 'MacBook Pro 13 pol M1 2020', 'Bateria não carrega e conector USB-C frouxo', 'Orçamento', 'Aparelho sem marcas de queda', 'Desgaste do circuito de alimentação e porta de entrada Thunderbolt 3.', 750.00, 0.00, 750.00, 'real', 2, 1, NULL, 0, NULL)
ON DUPLICATE KEY UPDATE `descricaoProduto` = VALUES(`descricaoProduto`), `valorTotal` = VALUES(`valorTotal`), `status` = VALUES(`status`);

-- 8. Vendas
INSERT INTO `vendas` (`idVendas`, `dataVenda`, `valorTotal`, `desconto`, `valor_desconto`, `tipo_desconto`, `faturado`, `observacoes`, `observacoes_cliente`, `clientes_id`, `usuarios_id`, `lancamentos_id`, `status`, `garantia`) VALUES
(1, '2026-03-05', 960.00, 0.00, 960.00, 'real', 1, 'Venda balcão - upgrade de equipamentos', 'Pagamento à vista via Pix', 1, 1, NULL, 'Faturado', 90),
(2, '2026-03-14', 1160.00, 50.00, 1110.00, 'real', 1, 'Equipamentos de infraestrutura para TechLog', 'Entregue com nota fiscal e garantia', 3, 1, NULL, 'Faturado', 180)
ON DUPLICATE KEY UPDATE `valorTotal` = VALUES(`valorTotal`), `status` = VALUES(`status`);

-- 9. Lançamentos Financeiros
INSERT INTO `lancamentos` (`idLancamentos`, `descricao`, `valor`, `desconto`, `valor_desconto`, `tipo_desconto`, `data_vencimento`, `data_pagamento`, `baixado`, `cliente_fornecedor`, `forma_pgto`, `tipo`, `anexo`, `observacoes`, `clientes_id`, `categorias_id`, `contas_id`, `vendas_id`, `usuarios_id`) VALUES
(1, 'Recebimento OS #1 - Carlos Alberto', 660.00, 0.00, 660.00, 'real', '2026-03-03', '2026-03-03', 1, 'Carlos Alberto Medeiros', 'Pix', 'receita', NULL, 'OS finalizada e paga', 1, 1, 1, NULL, 1),
(2, 'Venda de Hardwares #1 - Upgrade SSD e RAM', 960.00, 0.00, 960.00, 'real', '2026-03-05', '2026-03-05', 1, 'Carlos Alberto Medeiros', 'Pix', 'receita', NULL, 'Venda balcão faturada', 1, 2, 1, 1, 1),
(3, 'Venda de Switch & Rede #2 - TechLog', 1110.00, 0.00, 1110.00, 'real', '2026-03-14', '2026-03-14', 1, 'TechLog Logística', 'Transferência Bancária', 'receita', NULL, 'Venda corporativa', 3, 2, 1, 2, 1),
(4, 'Aquisição de Peças - Fornecedor Global Tech', 2450.00, 0.00, 2450.00, 'real', '2026-03-10', '2026-03-10', 1, 'Distribuidora Global Tech Brasil', 'Boleto', 'despesa', NULL, 'Reposição de estoque de SSDs e memórias', 4, 5, 1, NULL, 1),
(5, 'Conta de Energia Elétrica e Internet Fibra', 480.00, 0.00, 480.00, 'real', '2026-03-25', NULL, 0, 'Enel / Vivo Empresas', 'Boleto', 'despesa', NULL, 'Despesas fixas da oficina', NULL, 5, 1, NULL, 1),
(6, 'Recebimento Previsto OS #3 - Servidor TechLog', 1160.00, 0.00, 1160.00, 'real', '2026-03-22', NULL, 0, 'TechLog Logística', 'Boleto', 'receita', NULL, 'Previsão de encerramento da OS', 3, 1, 1, NULL, 1)
ON DUPLICATE KEY UPDATE `descricao` = VALUES(`descricao`), `valor` = VALUES(`valor`);

SET FOREIGN_KEY_CHECKS = 1;
