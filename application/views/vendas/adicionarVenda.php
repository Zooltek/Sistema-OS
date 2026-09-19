<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-cart-plus"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Iniciar Nova Venda</h1>
                <p class="amura-header-subtitle">Etapa 1 de 2: Definição de cliente, vendedor, status comercial e notas</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/vendas'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <!-- Card do Formulário -->
    <div class="amura-form-card">
        <form action="<?php echo current_url(); ?>" method="post" id="formVendas">
            <div class="amura-form-section">
                <div style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.25); color: #93c5fd; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.86rem; display: flex; align-items: center; gap: 10px;">
                    <i class="bx bx-info-circle" style="font-size: 1.3rem; color: #60a5fa;"></i>
                    <div>
                        <strong>Fluxo de Venda (Etapa 1):</strong> Selecione o cliente e parâmetros da venda. Ao clicar em <strong>"Continuar para Adicionar Produtos"</strong>, você poderá bipar códigos de barra ou incluir itens do estoque.
                    </div>
                </div>

                <?php if ($custom_error == true) { ?>
                    <div class="alert alert-danger" style="background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3); color: #fca5a5; border-radius: 6px; padding: 12px 16px; margin-bottom: 16px;">
                        Dados incompletos, verifique os campos obrigatórios ou selecione cliente e responsável corretamente.
                    </div>
                <?php } ?>

                <h3 class="amura-form-section-title">
                    <i class="bx bx-file"></i> Dados da Venda
                </h3>

                <div style="display: grid; grid-template-columns: 140px 1.5fr 1.5fr 150px 120px; gap: 12px; margin-bottom: 16px;">
                    <div class="control-group amura-form-group">
                        <label for="dataVenda" class="control-label amura-form-label">Data Venda <span class="required">*</span></label>
                        <div class="controls">
                            <input id="dataVenda" class="amura-form-input datepicker" type="text" name="dataVenda" value="<?php echo date('d/m/Y'); ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="cliente" class="control-label amura-form-label">Cliente <span class="required">*</span></label>
                        <div class="controls" style="position: relative;">
                            <input id="cliente" class="amura-form-input" type="text" name="cliente" value="" placeholder="Digite o nome do cliente..." autocomplete="off" />
                            <input id="clientes_id" type="hidden" name="clientes_id" value="" />
                            <div class="addclient" style="position: absolute; top: 100%; left: 0; z-index: 10; margin-top: 4px;">
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
                                    <a href="<?php echo base_url(); ?>index.php/clientes/adicionar" target="_blank" class="btn-amura-primary" style="padding: 4px 10px; font-size: 0.78rem;">
                                        <i class="fas fa-plus"></i> Cadastrar Novo Cliente
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="tecnico" class="control-label amura-form-label">Vendedor / Resp. <span class="required">*</span></label>
                        <div class="controls">
                            <input id="tecnico" class="amura-form-input" type="text" name="tecnico" value="<?= $this->session->userdata('nome_admin'); ?>" placeholder="Nome do vendedor" autocomplete="off" />
                            <input id="usuarios_id" type="hidden" name="usuarios_id" value="<?= $this->session->userdata('id_admin'); ?>" />
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="status" class="control-label amura-form-label">Status <span class="required">*</span></label>
                        <div class="controls">
                            <select class="amura-form-select" name="status" id="status">
                                <option value="Orçamento">Orçamento</option>
                                <option value="Aberto">Aberto</option>
                                <option value="Faturado">Faturado</option>
                                <option value="Em Andamento">Em Andamento</option>
                                <option value="Finalizado">Finalizado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Aguardando Peças">Aguardando Peças</option>
                                <option value="Aprovado">Aprovado</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="garantia" class="control-label amura-form-label">Garantia (dias)</label>
                        <div class="controls">
                            <input id="garantia" type="number" placeholder="Ex: 90" min="0" max="9999" class="amura-form-input" name="garantia" value="" />
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 12px;">
                    <div class="control-group amura-form-group">
                        <label for="observacoes" class="control-label amura-form-label">Observações Internas (Uso da Empresa)</label>
                        <div class="controls">
                            <textarea class="editor" name="observacoes" id="observacoes" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="observacoes_cliente" class="control-label amura-form-label">Observações ao Cliente (Impressas no Pedido)</label>
                        <div class="controls">
                            <textarea class="editor" name="observacoes_cliente" id="observacoes_cliente" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="amura-form-actions">
                <a href="<?php echo base_url('index.php/vendas') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary" id="btnContinuar">
                    <i class='bx bx-chevrons-right'></i> Continuar para Adicionar Produtos
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.addclient').hide();
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteCliente",
            minLength: 1,
            close: function(ui) { if(ui.label == 'Adicionar cliente...') ui.target.value = ''; },
            select: function(event, ui) {
                if (ui.item.label == 'Adicionar cliente...') {
                    $('.addclient').show();
                } else {
                    $("#clientes_id").val(ui.item.id);
                    $('.addclient').hide();
                }
            }
        });
        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/vendas/autoCompleteUsuario",
            minLength: 1,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });
        $("#formVendas").validate({
            rules: {
                cliente: { required: true },
                tecnico: { required: true },
                dataVenda: { required: true }
            },
            messages: {
                cliente: { required: 'Campo Requerido.' },
                tecnico: { required: 'Campo Requerido.' },
                dataVenda: { required: 'Campo Requerido.' }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
            }
        });
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $('.editor').trumbowyg({
            lang: 'pt_br',
            semantic: { 'strikethrough': 's' }
        });
        $('.addclient').hide();
    });
</script>
