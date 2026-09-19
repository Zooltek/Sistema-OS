<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<div class="amura-page">
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Editar Venda #<?php echo $result->idVendas; ?></h1>
                <p class="amura-header-subtitle">Cliente: <strong><?php echo htmlspecialchars($result->nomeCliente); ?></strong> | Status: <span class="badge badge-default"><?php echo $result->status; ?></span></p>
            </div>
        </div>
        <div class="amura-header-actions" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <?php if ($result->faturado == 0) { ?>
                <a href="#modal-faturar" id="btn-faturar-header" role="button" data-toggle="modal" class="btn-amura-danger">
                    <i class='bx bx-dollar'></i> Faturar
                </a>
            <?php } else { ?>
                <span class="badge badge-success" style="margin: 0; padding: 6px 12px; font-size: 0.85rem;"><i class="fas fa-check"></i> Faturada</span>
            <?php } ?>
            <a title="Visualizar Venda" class="btn-amura-secondary" href="<?php echo site_url() ?>/vendas/visualizar/<?php echo $result->idVendas; ?>">
                <i class="bx bx-show"></i> Visualizar
            </a>
            <a title="Voltar para Vendas" class="btn-amura-secondary" href="<?php echo site_url() ?>/vendas">
                <i class="bx bx-arrow-back"></i> Voltar
            </a>
        </div>
    </div>

    <div class="amura-form-card" style="padding: 0; overflow: visible;">
        <div class="tab-content" style="overflow: visible;">
                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab"><i class="fas fa-file-invoice"></i> Detalhes da Venda</a></li>
                        <li id="tabProdutos"><a href="#tab2" data-toggle="tab"><i class="fas fa-boxes"></i> Produtos <span class="badge <?= count($produtos) > 0 ? 'badge-success' : 'badge-important' ?>" id="badgeQtdProdutos"><?php echo count($produtos); ?></span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="span12" id="divEditarVenda">
                                <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
                                    <?php echo form_hidden('idVendas', $result->idVendas) ?>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <h3>Venda:
                                            <?php echo $result->idVendas ?>
                                        </h3>
                                        <div class="span2" style="margin-left: 0">
                                            <label for="dataFinal">Data Final</label>
                                            <input id="dataVenda" class="span12 datepicker" type="text" name="dataVenda" value="<?php echo date('d/m/Y', strtotime($result->dataVenda)); ?>" />
                                        </div>
                                        <div class="span3">
                                            <label for="cliente">Cliente<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>" />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="<?php echo $result->clientes_id ?>" />
                                            <input id="valorTotal" type="hidden" name="valorTotal" value="" />
                                        </div>
                                        <div class="span3">
                                            <label for="tecnico">Vendedor<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value="<?php echo $result->nome ?>" />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $result->usuarios_id ?>" />
                                        </div>
                                        <div class="span2">
                                            <label for="status">Status<span class="required">*</span></label>
                                            <select class="span12" name="status" id="status" value="">
                                                <option <?= $result->status == 'Orçamento' ? 'selected' : '' ?> value="Orçamento">Orçamento</option>
                                                <option <?= $result->status == 'Aberto' ? 'selected' : '' ?> value="Aberto">Aberto</option>
                                                <option <?= $result->status == 'Faturado' ? 'selected' : '' ?> value="Faturado">Faturado</option>
                                                <option <?= $result->status == 'Negociação' ? 'selected' : '' ?> value="Negociação">Negociação</option>
                                                <option <?= $result->status == 'Em Andamento' ? 'selected' : '' ?> value="Em Andamento">Em Andamento</option>
                                                <option <?= $result->status == 'Finalizado' ? 'selected' : '' ?> value="Finalizado">Finalizado</option>
                                                <option <?= $result->status == 'Cancelado' ? 'selected' : '' ?> value="Cancelado">Cancelado</option>
                                                <option <?= $result->status == 'Aguardando Peças' ? 'selected' : '' ?>value="Aguardando Peças">Aguardando Peças</option>
                                                <option <?= $result->status == 'Aprovado' ? 'selected' : '' ?> value="Aprovado">Aprovado</option>
                                            </select>
                                        </div>
                                        <div class="span2">
                                            <label for="garantia">Garantia (dias)</label>
                                            <input id="garantia" type="number" placeholder="Em dias" min="0" max="9999"
                                                class="span12" name="garantia"
                                                value="<?php echo $result->garantia ?>" />
                                            <?php echo form_error('garantia'); ?>
                                        </div>
                                    </div>

                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="observacoes">
                                            <h4>Observações Internas</h4>
                                        </label>
                                        <textarea class="editor" name="observacoes" id="observacoes" cols="30" rows="5"><?php echo $result->observacoes ?></textarea>
                                    </div>

                                    <div class="span6" style="padding: 1%; margin-left: 0">
                                        <label for="observacoes_cliente">
                                            <h4>Observações ao Cliente</h4>
                                        </label>
                                        <textarea class="editor" name="observacoes_cliente" id="observacoes_cliente" cols="30" rows="5"><?php echo $result->observacoes_cliente ?></textarea>
                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span12" style="display:flex; justify-content: center;">
                                            <?php if ($result->faturado == 0) { ?>
                                                <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="button btn btn-danger">
                                                    <span class="button__icon"><i class='bx bx-dollar'></i></span> 
                                                    <span class="button__text2">Faturar</span>
                                                </a>
                                            <?php } ?>
                                            <button class="button btn btn-primary" id="btnContinuar">
                                                <span class="button__icon"><i class="bx bx-sync"></i></span>
                                                <span class="button__text2">Atualizar</span>
                                            </button>
                                            <a href="<?php echo base_url() ?>index.php/vendas/visualizar/<?php echo $result->idVendas; ?>" class="button btn btn-primary">
                                                <span class="button__icon"><i class="bx bx-show"></i></span>
                                                <span class="button__text2">Visualizar</span>
                                            </a>
                                            <a href="<?php echo base_url() ?>index.php/vendas" class="button btn btn-warning">
                                                <span class="button__icon"><i class="bx bx-undo"></i></span>
                                                <span class="button__text2">Voltar</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="span12 well" style="padding: 1.5%; margin-left: 0; background: #fdfdfd; border: 1px solid #e0e0e0; border-radius: 6px;">
                                <div class="span12" style="margin-left: 0; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                                    <h4 style="margin: 0; color: #2c3e50;"><i class="fas fa-barcode"></i> Inserir Produtos na Venda</h4>
                                    <button type="button" class="btn btn-info" id="btnAbrirCatalogo" style="font-weight: 600; padding: 6px 14px; border-radius: 4px;">
                                        <i class="fas fa-search-plus"></i> Abrir Catálogo de Produtos
                                    </button>
                                </div>
                                <div class="span12" style="margin-left: 0;">
                                    <form id="formProdutos" action="<?php echo base_url(); ?>index.php/vendas/adicionarProduto" method="post" style="margin-bottom: 6px;">
                                        <div class="span6" style="margin-left: 0;">
                                            <input type="hidden" name="idProduto" id="idProduto" />
                                            <input type="hidden" name="idVendasProduto" id="idVendasProduto" value="<?php echo $result->idVendas ?>" />
                                            <input type="hidden" name="estoque" id="estoque" value="" />
                                            <label for="produto"><strong>Produto (Nome ou Código de Barras)</strong></label>
                                            <div style="position: relative;">
                                                <input type="text" class="span12" name="produto" id="produto" placeholder="Digite o nome ou bipe o código de barras..." autocomplete="off" style="padding-right: 32px;" />
                                                <span id="barcodeIcon" style="position: absolute; right: 10px; top: 7px; color: #888; pointer-events: none;"><i class="fas fa-barcode"></i></span>
                                            </div>
                                        </div>
                                        <div class="span2">
                                            <label for="preco">Preço Unitário</label>
                                            <input type="text" placeholder="Preço" id="preco" name="preco" class="span12 money" />
                                        </div>
                                        <div class="span2">
                                            <label for="quantidade">Quantidade</label>
                                            <input type="text" placeholder="Qtd" id="quantidade" name="quantidade" value="1" class="span12" />
                                        </div>
                                        <div class="span2" style="margin-top: 25px;">
                                            <button class="button btn btn-success span12" id="btnAdicionarProduto" style="margin: 0; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Adicionar</span>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="span12" style="margin-left: 0; font-size: 12px; color: #666; margin-bottom: 10px;">
                                        <i class="fas fa-info-circle" style="color: #0088cc;"></i> <strong>Dica rápida:</strong> Você pode digitar para autocompletar, abrir o <strong>Catálogo</strong> para buscar e inserir com 1 clique, ou usar o <strong>leitor de código de barras</strong> e teclar <kbd>Enter</kbd>.
                                    </div>
                                </div>
                                <div class="span12" style="margin-left: 0; border-top: 1px dashed #e0e0e0; padding-top: 10px;">
                                    <form id="formDesconto" action="<?php echo base_url(); ?>index.php/vendas/adicionarDesconto" method="POST" style="margin-bottom: 0;">
                                        <div class="span1">
                                            <input type="hidden" name="idVendas" id="idVendas" value="<?php echo $result->idVendas; ?>" />
                                            <label for="">Desconto</label>
                                            <input style="width: 4em;" id="desconto" name="desconto" type="text" placeholder="0.00" maxlength="6" size="2" /><br />
                                            <strong><span style="color: red" id="errorAlert"></span></strong>
                                        </div>
                                        <div class="span1">
                                        <label for="">Tipo Desc.</label>
                                        <select style="width: 4em;" name="tipoDesconto" id="tipoDesconto">
                                            <option value="real">R$</option>
                                            <option value="porcento" <?=$result->tipo_desconto == "porcento" ? "selected" : "" ?>>%</option>
                                        </select>
                                        <strong><span style="color: red" id="errorAlert"></span></strong>
                                        </div>
                                        <div class="span2">
                                            <label for="">Total com Desconto</label>
                                            <input class="span12 money" id="resultado" type="text" data-affixes-stay="true" data-thousands="" data-decimal="." name="resultado" value="" readonly />
                                        </div>
                                        <div class="span2">
                                            <label for="">&nbsp;</label>
                                            <button class="button btn btn-success" id="btnAdicionarDesconto">
                                                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Aplicar</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="span12" id="divProdutos" style="margin-left: 0">
                                <table class="table table-bordered amura-table" id="tblProdutos">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th width="8%">Quantidade</th>
                                            <th width="10%">Preço</th>
                                            <th width="6%">Ações</th>
                                            <th width="10%">Sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        if (empty($produtos)) { ?>
                                            <tr id="linhaSemProdutos">
                                                <td colspan="5" style="text-align: center; padding: 25px; color: #8c97a8;">
                                                    <i class="fas fa-shopping-basket" style="font-size: 32px; color: #ff9204; display: block; margin-bottom: 8px;"></i>
                                                    <strong>Nenhum produto adicionado nesta venda ainda.</strong><br>
                                                    <span style="font-size: 13px; color: #8c97a8;">Digite o nome ou bipe o código de barras acima, ou clique no botão <strong>Abrir Catálogo de Produtos</strong> para incluir itens.</span>
                                                </td>
                                            </tr>
                                        <?php } else {
                                            foreach ($produtos as $p) {
                                                $preco = $p->preco ?: $p->precoVenda;
                                                $total = $total + $p->subTotal;
                                                echo '<tr>';
                                                echo '<td>' . $p->descricao . '</td>';
                                                echo '<td><div align="center">' . $p->quantidade . '</div></td>';
                                                echo '<td><div align="center">R$: ' . $preco . '</div></td>';
                                                echo '<td><div align="center"><a href="" idAcao="' . $p->idItens . '" prodAcao="' . $p->idProdutos . '" quantAcao="' . $p->quantidade . '" title="Excluir Produto" class="btn-nwe4 amura-action-btn delete"><i class="bx bx-trash-alt"></i></a></div></td>';
                                                echo '<td><div align="center">R$: ' . number_format($p->subTotal, 2, '.', '') . '</div></td>';
                                                echo '</tr>';
                                            }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" style="text-align: right"><strong>Total:</strong></td>
                                            <td>
                                                <div align="center"><strong>R$: <?php echo number_format($total, 2, '.', ''); ?></strong></div> <input type="hidden" id="total-venda" value="<?php echo number_format($total, 2, '.', ''); ?>">
                                            </td>
                                        </tr>
                                        <?php if ($result->valor_desconto != 0 && $result->desconto != 0) {
                                            ?>
                                            <tr>
                                                <td colspan="4" style="text-align: right"><strong>Desconto:</strong></td>
                                                <td>
                                                    <div align="center"><strong><?php echo $result->tipo_desconto == "real" ? "R$ " : ""; ?> <?php echo number_format($result->desconto, 2, '.', ''); ?> <?php echo $result->tipo_desconto == "porcento" ? " %" : ""; ?></strong></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right"><strong>Total Com Desconto:</strong></td>
                                                <td>
                                                    <div align="center"><strong>R$: <?php echo number_format($result->valor_desconto, 2, '.', ''); ?></strong></div><input type="hidden" id="total-desconto" value="<?php echo number_format($result->valor_desconto, 2, '.', ''); ?>">
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </tfoot>
                                </table>

                                <div class="span12" style="margin-left: 0; margin-top: 15px; margin-bottom: 25px; padding: 16px 20px; background: rgba(255, 146, 4, 0.05); border: 1px solid rgba(255, 146, 4, 0.2); border-radius: 8px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                                    <div>
                                        <h5 style="margin: 0 0 4px 0; color: #ff9204; font-size: 15px;"><i class="fas fa-check-circle" style="color: #10b981;"></i> Produtos Lançados</h5>
                                        <span style="font-size: 13px; color: #8c97a8;">
                                            Os produtos e descontos já foram salvos nesta venda. Escolha o próximo passo:
                                        </span>
                                    </div>
                                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                        <?php if ($result->faturado == 0) { ?>
                                            <a href="#modal-faturar" id="btn-faturar-tab2" role="button" data-toggle="modal" class="btn-amura-primary" style="padding: 8px 18px;">
                                                <i class='bx bx-dollar'></i> Faturar Venda / Pagamento
                                            </a>
                                        <?php } else { ?>
                                            <span class="badge badge-success" style="padding: 8px 14px; font-size: 13px;"><i class="fas fa-check"></i> Venda Faturada</span>
                                        <?php } ?>
                                        <a href="<?php echo base_url() ?>index.php/vendas/visualizar/<?php echo $result->idVendas; ?>" class="btn-amura-secondary" style="padding: 8px 16px;">
                                            <i class="bx bx-show"></i> Visualizar / Imprimir
                                        </a>
                                        <a href="<?php echo base_url() ?>index.php/vendas" class="btn-amura-secondary" style="padding: 8px 16px;">
                                            <i class="bx bx-undo"></i> Voltar para Vendas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Catálogo de Produtos -->
<div id="modal-catalogo-produtos" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-hidden="true" style="width: 860px; margin-left: -430px; border-radius: 8px;">
    <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 20px;">
        <h4 style="margin: 0; color: #ff9204;"><i class="fas fa-boxes"></i> Catálogo de Produtos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body" style="padding: 15px 20px; max-height: 480px;">
        <div style="margin-bottom: 12px; position: relative;">
            <input type="text" id="filtroCatalogo" class="span12" placeholder="Digite o nome ou código de barras para filtrar..." autocomplete="off" style="padding: 10px 35px 10px 12px; font-size: 14px; border-radius: 6px; box-shadow: none; margin-bottom: 0;">
            <i class="fas fa-search" style="position: absolute; right: 12px; top: 12px; color: #888;"></i>
        </div>
        <div style="overflow-y: auto; max-height: 380px; border: 1px solid #232d3b; border-radius: 4px;">
            <table class="table table-bordered amura-table" id="tblCatalogoProdutos" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th width="18%">Cód. Barras</th>
                        <th>Descrição</th>
                        <th width="14%">Estoque</th>
                        <th width="16%">Preço Venda</th>
                        <th width="14%" style="text-align: center;">Ação</th>
                    </tr>
                </thead>
                <tbody id="listaCatalogoCorpo">
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #888;">
                            <i class="fas fa-spinner fa-spin"></i> Carregando produtos do catálogo...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer" style="padding: 10px 20px;">
        <button class="btn" data-dismiss="modal"><i class="fas fa-times"></i> Fechar</button>
    </div>
</div>

<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formFaturar" action="<?php echo current_url() ?>" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Faturar Venda</h3>
        </div>
        <div class="modal-body">
            <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
            <div class="span12" style="margin-left: 0">
                <label for="descricao">Descrição</label>
                <input class="span12" id="descricao" type="text" name="descricao" value="Fatura de Venda Nº: <?php echo $result->idVendas; ?> " />
            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span12" style="margin-left: 0">
                    <label for="cliente">Cliente*</label>
                    <input class="span12" id="cliente" type="text" name="cliente" value="<?php echo $result->nomeCliente ?>" />
                    <input type="hidden" name="clientes_id" id="clientes_id" value="<?php echo $result->clientes_id ?>">
                    <input type="hidden" name="vendas_id" id="vendas_id" value="<?php echo $result->idVendas; ?>">
                </div>
            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span5" style="margin-left: 0">
                    <label for="valor">Valor*</label>
                    <input type="hidden" id="tipo" name="tipo" value="receita" />
                    <input class="span12 money" id="valor" type="text" name="valor" value="<?php echo number_format($total, 2, '.', ''); ?> " />
                </div>
                <div class="span5" style="margin-left: 2">
                    <label for="valor">Valor Com Desconto*</label>
                    <input class="span12 money" id="faturar-desconto" type="text" name="faturar-desconto" value="<?php echo number_format($result->valor_desconto, 2, '.', ''); ?> " />
                </div>
            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span4" style="margin-left: 0">
                    <label for="vencimento">Data Entrada*</label>
                    <input class="span12 datepicker" autocomplete="off" id="vencimento" type="text" name="vencimento" />
                </div>
            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span4" style="margin-left: 0">
                    <label for="recebido">Recebido?</label>
                    &nbsp &nbsp &nbsp &nbsp<input id="recebido" type="checkbox" name="recebido" value="1" />
                </div>
                <div id="divRecebimento" class="span8" style=" display: none">
                    <div class="span6">
                        <label for="recebimento">Data Recebimento</label>
                        <input class="span12 datepicker" autocomplete="off" id="recebimento" type="text" name="recebimento" />
                    </div>
                    <div class="span6">
                        <label for="formaPgto">Forma Pgto</label>
                        <select name="formaPgto" id="formaPgto" class="span12">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Débito">Débito</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Depósito">Depósito</option>
                            <option value="Pix">Pix</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true" id="btn-cancelar-faturar">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-dollar'></i></span> <span class="button__text2">Faturar</span></button>
        </div>        
    </form>
</div>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    
    $("#quantidade").keyup(function() {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    function calcDesconto(valor, desconto, tipoDesconto) {
        var resultado = 0;
        if (tipoDesconto == 'real') {
            resultado = valor - desconto;
        }
        if (tipoDesconto == 'porcento') {
            resultado = (valor - desconto * valor / 100).toFixed(2);
        }
        return resultado;
    }

    function validarDesconto(resultado, valor) {
        if (resultado == valor) {
            return resultado = "";
        } else {
            return resultado.toFixed(2);
        }
    }
    var valorBackup = $("#total-venda").val();

    $("#desconto").keyup(function() {

        this.value = this.value.replace(/[^0-9.]/g, '');
        if ($("#total-venda").val() == null || $("#total-venda").val() == '') {
            $('#errorAlert').text('Valor não pode ser apagado.').css("display", "inline").fadeOut(5000);
            $('#desconto').val('');
            $('#resultado').val('');
            $("#total-venda").val(valorBackup);
            $("#desconto").focus();

        } else if (Number($("#desconto").val()) >= 0) {
            $('#resultado').val(calcDesconto(Number($("#total-venda").val()), Number($("#desconto").val()), $("#tipoDesconto").val()));
            $('#resultado').val(validarDesconto(Number($('#resultado').val()), Number($("#total-venda").val())));
        } else {
            $('#errorAlert').text('Erro desconhecido.').css("display", "inline").fadeOut(5000);
            $('#desconto').val('');
            $('#resultado').val('');
        }
    });
    $('#tipoDesconto').on('change', function() {
        if (Number($("#desconto").val()) >= 0) {
            $('#resultado').val(calcDesconto(Number($("#total-venda").val()), Number($("#desconto").val()), $("#tipoDesconto").val()));
            $('#resultado').val(validarDesconto(Number($('#resultado').val()), Number($("#total-venda").val())));
        }
    });

    $("#total-venda").focusout(function() {
        $("#total-venda").val(valorBackup);
        if ($("#total-venda").val() == '0.00' && $('#resultado').val() != '') {
            $('#errorAlert').text('Você não pode apagar o valor.').css("display", "inline").fadeOut(6000);
            $('#resultado').val('');
            $("#total-venda").val(valorBackup);
            $('#resultado').val(calcDesconto(Number($("#total-venda").val()), Number($("#desconto").val()), $("#tipoDesconto").val()));
            $('#resultado').val(validarDesconto(Number($('#resultado').val()), Number($("#total-venda").val())));
            $("#desconto").focus();
        } else {
            $('#resultado').val(calcDesconto(Number($("#total-venda").val()), Number($("#desconto").val()), $("#tipoDesconto").val()));
            $('#resultado').val(validarDesconto(Number($('#resultado').val()), Number($("#total-venda").val())));
        }
    });

    $('#resultado').focusout(function() {
        if (Number($('#resultado').val()) > Number($("#total-venda").val())) {
            $('#errorAlert').text('Desconto não pode ser maior que o Valor.').css("display", "inline").fadeOut(6000);
            $('#resultado').val('');
        }
        if ($("#desconto").val() != "" || $("#desconto").val() != null) {
            $('#resultado').val(calcDesconto(Number($("#total-venda").val()), Number($("#desconto").val())));
            $('#resultado').val(validarDesconto(Number($('#resultado').val()), Number($("#total-venda").val())));
        }
    });

    $(document).ready(function() {
        $(".money").maskMoney();
        $('#recebido').click(function(event) {
            var flag = $(this).is(':checked');
            if (flag == true) {
                $('#divRecebimento').show();
            } else {
                $('#divRecebimento').hide();
            }
        });
        $(document).on('click', '#btn-faturar, #btn-faturar-header, #btn-faturar-tab2', function(event) {
            event.preventDefault();
            valor = $('#total-venda').val() || '0.00';
            valor_desconto = $('#total-desconto').val() || '0.00';
            valor_desconto != 0.00 || valor_desconto ? $('#valor').attr('readonly', false) : $('#faturar-desconto').attr('readonly', false);
            valor = valor.replace(',', '');
            $('#valor').val(valor);
            $('#modal-faturar').modal('show');
        });
        $('#formDesconto').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processando',
                        text: 'Registrando desconto...',
                        icon: 'info',
                        showCloseButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                },
                success: function(response) {
                    if (response.result) {
                        Swal.fire({
                            type: "success",
                            title: "Sucesso",
                            text: response.messages
                        });
                        $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos");
                        $("#desconto").val("");
                        $("#resultado").val("");
                        /*setTimeout(function() {
                            window.location.href = window.BaseUrl + 'index.php/vendas/editar/' + <?php echo $result->idVendas ?>;
                        }, 2000);*/
                    } else {
                        Swal.fire({
                            type: "error",
                            title: "Atenção",
                            text: response.messages
                        });
                        $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos");
                        $("#desconto").val("");
                        $("#resultado").val("");
                    }

                },
                error: function(response) {
                    Swal.fire({
                        type: "error",
                        title: "Atenção",
                        text: response.responseJSON.messages
                    });
                    $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos");
                    $("#desconto").val("");
                    $("#resultado").val("");
                }
            });
        });
        $("#formFaturar").validate({
            rules: {
                descricao: {
                    required: true
                },
                cliente: {
                    required: true
                },
                valor: {
                    required: true
                },
                vencimento: {
                    required: true
                }
            },
            messages: {
                descricao: {
                    required: 'Campo Requerido.'
                },
                cliente: {
                    required: 'Campo Requerido.'
                },
                valor: {
                    required: 'Campo Requerido.'
                },
                vencimento: {
                    required: 'Campo Requerido.'
                }
            },
            submitHandler: function(form) {
                var dados = $(form).serialize();
                var qtdProdutos = $('#tblProdutos >tbody >tr').length;

                $('#btn-cancelar-faturar').trigger('click');

                if (qtdProdutos <= 0) {
                    Swal.fire({
                        type: "error",
                        title: "Atenção",
                        text: "Não é possível faturar uma venda sem produtos"
                    });
                } else if (qtdProdutos > 0) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/vendas/faturar",
                        data: dados,
                        dataType: 'json',
                        success: function(data) {
                            if (data.result == true) {
                                window.location.reload(true);
                            } else {
                                Swal.fire({
                                    type: "error",
                                    title: "Atenção",
                                    text: "Ocorreu um erro ao tentar faturar venda."
                                });
                                $('#progress-fatura').hide();
                            }
                        }
                    });

                    return false;
                }
            }
        });
        $("#produto").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteProduto",
            minLength: 1,
            select: function(event, ui) {
                $("#idProduto").val(ui.item.id);
                $("#estoque").val(ui.item.estoque);
                $("#preco").val(ui.item.preco);
                $("#quantidade").val('1').focus().select();
            }
        });

        // Suporte para leitor de código de barras ou Enter direto no campo de produto
        $("#produto").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                var val = $(this).val().trim();
                if (!val) return;

                if ($("#idProduto").val() && $("#preco").val()) {
                    $("#formProdutos").submit();
                    return;
                }

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/vendas/getProdutoPorCodigo",
                    type: "GET",
                    data: { codigo: val },
                    dataType: "json",
                    success: function(res) {
                        if (res.result && res.produto) {
                            $("#idProduto").val(res.produto.id);
                            $("#estoque").val(res.produto.estoque);
                            $("#preco").val(res.produto.preco);
                            $("#produto").val(res.produto.descricao);
                            $("#quantidade").val('1');
                            $("#formProdutos").submit();
                        } else {
                            $("#produto").autocomplete("search", val);
                        }
                    }
                });
            }
        });

        // Catálogo de Produtos
        function carregarCatalogo(termo) {
            $("#listaCatalogoCorpo").html('<tr><td colspan="5" style="text-align: center; padding: 20px; color: #888;"><i class="fas fa-spinner fa-spin"></i> Carregando produtos...</td></tr>');
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/vendas/catalogoProdutos",
                type: "GET",
                data: { termo: termo || '' },
                dataType: "json",
                success: function(res) {
                    if (res.result && res.produtos && res.produtos.length > 0) {
                        var html = '';
                        $.each(res.produtos, function(i, prod) {
                            var precoNum = parseFloat(prod.precoVenda);
                            var precoFmt = isNaN(precoNum) ? 'R$ 0,00' : precoNum.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                            var cod = prod.codDeBarra ? prod.codDeBarra : '<span style="color: #bbb;">S/ Cód</span>';
                            html += '<tr>';
                            html += '<td><code>' + cod + '</code></td>';
                            html += '<td><strong>' + prod.descricao + '</strong></td>';
                            html += '<td>' + prod.estoque + ' ' + (prod.unidade || 'UN') + '</td>';
                            html += '<td style="color: #2e7d32; font-weight: bold;">' + precoFmt + '</td>';
                            html += '<td style="text-align: center;">';
                            html += '<button type="button" class="btn btn-mini btn-success btnInserirDoCatalogo" data-id="' + prod.idProdutos + '" data-nome="' + prod.descricao + '" data-preco="' + prod.precoVenda + '" data-estoque="' + prod.estoque + '"><i class="fas fa-plus"></i> Inserir</button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        $("#listaCatalogoCorpo").html(html);
                    } else {
                        $("#listaCatalogoCorpo").html('<tr><td colspan="5" style="text-align: center; padding: 20px; color: #888;">Nenhum produto encontrado.</td></tr>');
                    }
                },
                error: function() {
                    $("#listaCatalogoCorpo").html('<tr><td colspan="5" style="text-align: center; padding: 20px; color: #c00;">Erro ao consultar catálogo.</td></tr>');
                }
            });
        }

        $("#btnAbrirCatalogo").on("click", function(e) {
            e.preventDefault();
            $("#modal-catalogo-produtos").modal("show");
            $("#filtroCatalogo").val('');
            carregarCatalogo('');
            setTimeout(function() {
                $("#filtroCatalogo").focus();
            }, 400);
        });

        var timerFiltro = null;
        $("#filtroCatalogo").on("keyup", function() {
            var t = $(this).val();
            clearTimeout(timerFiltro);
            timerFiltro = setTimeout(function() {
                carregarCatalogo(t);
            }, 300);
        });

        $(document).on("click", ".btnInserirDoCatalogo", function() {
            var id = $(this).data("id");
            var nome = $(this).data("nome");
            var preco = $(this).data("preco");
            var estoque = $(this).data("estoque");

            $("#idProduto").val(id);
            $("#produto").val(nome);
            $("#preco").val(preco);
            $("#estoque").val(estoque);
            $("#quantidade").val("1");

            $("#modal-catalogo-produtos").modal("hide");
            $("#quantidade").focus().select();
        });

        function atualizarBadgeProdutos() {
            setTimeout(function() {
                var count = $("#tblProdutos tbody tr").not("#linhaSemProdutos").length;
                $("#badgeQtdProdutos").text(count);
                if (count > 0) {
                    $("#badgeQtdProdutos").removeClass("badge-important").addClass("badge-success");
                } else {
                    $("#badgeQtdProdutos").removeClass("badge-success").addClass("badge-important");
                }
            }, 300);
        }

        // Abertura automática na aba de produtos se não houver produtos ou com hash #tab2
        var totalItensAtuais = <?php echo count($produtos); ?>;
        if (window.location.hash === '#tab2' || totalItensAtuais === 0) {
            $('.nav-tabs a[href="#tab2"]').tab('show');
            setTimeout(function() {
                $("#produto").focus();
            }, 200);
        }

        $('a[data-toggle="tab"]').on('shown', function (e) {
            if ($(e.target).attr('href') === '#tab2') {
                setTimeout(function() {
                    $("#produto").focus();
                }, 100);
            }
        });

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 2,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });
        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 2,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });
        $("#formVendas").validate({
            rules: {
                cliente: {
                    required: true
                },
                tecnico: {
                    required: true
                },
                dataVenda: {
                    required: true
                }
            },
            messages: {
                cliente: {
                    required: 'Campo Requerido.'
                },
                tecnico: {
                    required: 'Campo Requerido.'
                },
                dataVenda: {
                    required: 'Campo Requerido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
        $("#formProdutos").validate({
            rules: {
                preco: {
                    required: true
                },
                quantidade: {
                    required: true
                }
            },
            messages: {
                preco: {
                    required: 'Insira o preço'
                },
                quantidade: {
                    required: 'Insira a quantidade'
                }
            },
            submitHandler: function(form) {
                var quantidade = parseInt($("#quantidade").val());
                var estoque = parseInt($("#estoque").val());

                <?php if (!$configuration['control_estoque']) {
                    echo 'estoque = 1000000';
                }; ?>

                if (estoque < quantidade) {
                    Swal.fire({
                        type: "warning",
                        title: "Atenção",
                        text: "Você não possui estoque suficiente."
                    });
                } else {
                    var dados = $(form).serialize();
                    $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/vendas/adicionarProduto",
                        data: dados,
                        dataType: 'json',
                        success: function(data) {
                            if (data.result == true) {
                                $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos", function() {
                                    atualizarBadgeProdutos();
                                });
                                $("#idProduto").val('');
                                $("#quantidade").val('1');
                                $("#preco").val('');
                                $("#produto").val('').focus();
                                $("#resultado").val("");
                                $("#desconto").val("");
                            } else {
                                Swal.fire({
                                    type: "error",
                                    title: "Atenção",
                                    html: "Ocorreu um erro ao tentar adicionar produto. <br /><br />Error: " + data.messages
                                });
                                $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos", function() {
                                    atualizarBadgeProdutos();
                                });
                                $('#formProdutos')[0].reset();
                                $("#quantidade").val('1');
                            }
                        }
                    });
                    return false;
                }
            }
        });
        $(document).on('click', 'a', function(event) {
            var idProduto = $(this).attr('idAcao');
            var quantidade = $(this).attr('quantAcao');
            var produto = $(this).attr('prodAcao');
            if ((idProduto % 1) == 0) {
                $("#divProdutos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/vendas/excluirProduto",
                    data: "idProduto=" + idProduto + "&idVendas=" + <?= $result->idVendas ?> + "&quantidade=" + quantidade + "&produto=" + produto,
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == true) {
                            $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos", function() {
                                atualizarBadgeProdutos();
                            });
                            $("#resultado").val("");
                            $("#desconto").val("");
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                html: "Ocorreu um erro ao tentar excluir produto." + data.messages
                            });
                            $("#divProdutos").load("<?php echo current_url(); ?> #divProdutos", function() {
                                atualizarBadgeProdutos();
                            });
                        }
                    }
                });
                return false;
            }
        });
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $('.editor').trumbowyg({
            lang: 'pt_br',
            semantic: { 'strikethrough': 's', }
        });
    });
</script>
