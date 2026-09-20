<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<div class="amura-page">
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Adicionar Ordem de Serviço</h1>
                <p class="amura-header-subtitle">Abertura de nova OS, vinculação de cliente, responsável e detalhamento inicial</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/os'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <div class="amura-form-card">
        <div class="tab-content" style="padding: 16px;">
            <div class="tab-pane active" id="tab1">
                <div id="divCadastrarOs">
                                <?php if ($custom_error == true) { ?>
                                    <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente cliente, responsável e garantia.<br />Ou se tem um cliente e um termo de garantia cadastrado.</div>
                                <?php
                                } ?>
                                <form action="<?php echo current_url(); ?>" method="post" id="formOs">
                                    <div class="span12" style="padding: 1%">
                                        <div class="span6">
                                            <label for="cliente">Cliente<span class="required">*</span></label>
                                            <input id="cliente" class="span12" type="text" name="cliente" value="" />
                                            <input id="clientes_id" class="span12" type="hidden" name="clientes_id" value="" />
                                        </div>
                                        <div class="span6">
                                            <label for="tecnico">Técnico / Responsável<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value="<?= $this->session->userdata('nome_admin'); ?>" />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?= $this->session->userdata('id_admin'); ?>" />
                                        </div>
                                    </div>
                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span3">
                                            <label for="status">Status<span class="required">*</span></label>
                                            <select class="span12" name="status" id="status" value="">
                                                <option value="Aberto">Aberto</option>
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Negociação">Negociação</option>
                                                <option value="Aprovado">Aprovado</option>
                                                <option value="Aguardando Peças">Aguardando Peças</option>
                                                <option value="Em Andamento">Em Andamento</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Faturado">Faturado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                        <div class="span3">
                                            <label for="dataInicial">Data Inicial<span class="required">*</span></label>
                                            <input id="dataInicial" autocomplete="off" class="span12 datepicker" type="text" name="dataInicial" value="<?php echo date('d/m/Y'); ?>" />
                                        </div>
                                        <div class="span3">
                                            <label for="dataFinal">Data Final<span class="required">*</span></label>
                                            <input id="dataFinal" autocomplete="off" class="span12 datepicker" type="text" name="dataFinal" value="" />
                                        </div>
                                        <div class="span3">
                                            <label for="garantia">Garantia (dias)</label>
                                            <input id="garantia" type="number" placeholder="Status s/g inserir nº/0" min="0" max="9999" class="span12" name="garantia" value="" />
                                            <?php echo form_error('garantia'); ?>
                                            <label for="termoGarantia">Termo Garantia</label>
                                            <input id="termoGarantia" class="span12" type="text" name="termoGarantia" value="" />
                                            <input id="garantias_id" class="span12" type="hidden" name="garantias_id" value="" />
                                        </div>
                                    </div>
                                    <!-- Seção Moderna de Detalhamento da OS -->
                                    <style>
                                        .os-modern-card {
                                            background: #212130;
                                            border: 1px solid #323248;
                                            border-radius: 8px;
                                            padding: 16px;
                                            margin-bottom: 18px;
                                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                                        }
                                        .os-card-header {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            margin-bottom: 12px;
                                            padding-bottom: 8px;
                                            border-bottom: 1px solid #2e2e42;
                                        }
                                        .os-card-title {
                                            font-size: 14px;
                                            font-weight: 600;
                                            color: #ff9204;
                                            display: flex;
                                            align-items: center;
                                            gap: 8px;
                                            margin: 0;
                                        }
                                        .os-quick-tags {
                                            display: flex;
                                            flex-wrap: wrap;
                                            gap: 6px;
                                            margin-top: 6px;
                                            margin-bottom: 10px;
                                        }
                                        .quick-tag-btn {
                                            background: #2b2b3d;
                                            color: #b5b5c3;
                                            border: 1px solid #3f3f58;
                                            border-radius: 4px;
                                            font-size: 11px;
                                            padding: 2px 8px;
                                            cursor: pointer;
                                            transition: all 0.2s ease;
                                        }
                                        .quick-tag-btn:hover {
                                            background: #ff9204;
                                            color: #fff;
                                            border-color: #ff9204;
                                        }
                                        .modern-textarea {
                                            width: 100% !important;
                                            box-sizing: border-box !important;
                                            background: #181824 !important;
                                            border: 1px solid #3a3a52 !important;
                                            color: #e4e6ef !important;
                                            border-radius: 6px !important;
                                            padding: 10px !important;
                                            font-size: 13px !important;
                                            line-height: 1.5 !important;
                                            resize: vertical !important;
                                            min-height: 90px;
                                            transition: border-color 0.2s ease;
                                        }
                                        .modern-textarea:focus {
                                            border-color: #ff9204 !important;
                                            outline: none !important;
                                            box-shadow: 0 0 0 2px rgba(255, 146, 4, 0.2) !important;
                                        }
                                        .toggle-editor-btn {
                                            font-size: 11px;
                                            color: #8c8c9e;
                                            background: transparent;
                                            border: none;
                                            cursor: pointer;
                                            text-decoration: underline;
                                            padding: 0;
                                        }
                                        .toggle-editor-btn:hover {
                                            color: #ff9204;
                                        }

                                        /* Modo Claro (body.white) */
                                        body.white .os-modern-card {
                                            background: #ffffff !important;
                                            border-color: rgba(0, 0, 0, 0.08) !important;
                                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
                                        }
                                        body.white .os-card-header {
                                            border-bottom-color: rgba(0, 0, 0, 0.08) !important;
                                        }
                                        body.white .os-card-title {
                                            color: #c47000 !important;
                                        }
                                        body.white .quick-tag-btn {
                                            background: #f1f5f9 !important;
                                            color: #475569 !important;
                                            border-color: #cbd5e1 !important;
                                        }
                                        body.white .quick-tag-btn:hover {
                                            background: #ea7b00 !important;
                                            color: #fff !important;
                                            border-color: #ea7b00 !important;
                                        }
                                        body.white .modern-textarea {
                                            background: #ffffff !important;
                                            border-color: #cbd5e1 !important;
                                            color: #1a202c !important;
                                        }
                                        body.white .modern-textarea:focus {
                                            border-color: #ea7b00 !important;
                                            box-shadow: 0 0 0 2px rgba(234, 123, 0, 0.15) !important;
                                        }
                                        body.white .toggle-editor-btn {
                                            color: #64748b !important;
                                        }
                                        body.white .toggle-editor-btn:hover {
                                            color: #ea7b00 !important;
                                        }
                                        body.white .os-modern-card label,
                                        body.white .os-modern-card label span,
                                        body.white #divCadastrarOs label {
                                            color: #1a202c !important;
                                        }
                                    </style>

                                    <div class="span12" style="margin-left: 0; padding: 0 1%;">
                                        <div class="row-fluid">
                                            <!-- Card 1: Equipamento e Defeito -->
                                            <div class="span6 os-modern-card" style="margin-left: 0; margin-bottom: 15px;">
                                                <div class="os-card-header">
                                                    <span class="os-card-title"><i class="fas fa-laptop"></i> Equipamento / Produto & Defeito</span>
                                                </div>

                                                <label for="descricaoProduto" style="font-weight: 600; font-size: 12px; color: #cfcfe0; display: flex; justify-content: space-between; align-items: center;">
                                                    <span>Descrição do Equipamento / Marca / Modelo / Nº Série</span>
                                                    <button type="button" class="toggle-editor-btn" onclick="toggleTrumbowyg('descricaoProduto')"><i class="fas fa-edit"></i> Alternar Formatador</button>
                                                </label>
                                                <div class="os-quick-tags">
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Notebook ')">+ Notebook</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Desktop/PC ')">+ PC</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Smartphone ')">+ Smartphone</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Impressora ')">+ Impressora</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Com fonte/carregador. ')">+ Com Fonte</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Sem carregador. ')">+ S/ Fonte</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('descricaoProduto', 'Aparelho com marcas normais de uso. ')">+ Marcas de uso</span>
                                                </div>
                                                <textarea class="modern-textarea editor-field" name="descricaoProduto" id="descricaoProduto" placeholder="Ex: Notebook Dell Inspiron 15, Cor Prata, S/N: 987654. Acompanha carregador original."></textarea>

                                                <div style="margin-top: 14px;">
                                                    <label for="defeito" style="font-weight: 600; font-size: 12px; color: #cfcfe0; display: flex; justify-content: space-between; align-items: center;">
                                                        <span>Defeito Reclamado pelo Cliente</span>
                                                        <button type="button" class="toggle-editor-btn" onclick="toggleTrumbowyg('defeito')"><i class="fas fa-edit"></i> Alternar Formatador</button>
                                                    </label>
                                                    <div class="os-quick-tags">
                                                        <span class="quick-tag-btn" onclick="addTextToField('defeito', 'Não liga. ')">+ Não liga</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('defeito', 'Sem imagem na tela / Tela preta. ')">+ Tela preta</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('defeito', 'Lento e travando. ')">+ Travando</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('defeito', 'Tela trincada/quebrada. ')">+ Tela quebrada</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('defeito', 'Não carrega a bateria. ')">+ Não carrega</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('defeito', 'Desliga sozinho após algum tempo de uso. ')">+ Desliga sozinho</span>
                                                    </div>
                                                    <textarea class="modern-textarea editor-field" name="defeito" id="defeito" placeholder="Relato do cliente sobre o problema apresentado..."></textarea>
                                                </div>
                                            </div>

                                            <!-- Card 2: Diagnóstico e Observações -->
                                            <div class="span6 os-modern-card" style="margin-bottom: 15px;">
                                                <div class="os-card-header">
                                                    <span class="os-card-title"><i class="fas fa-stethoscope"></i> Avaliação Técnica & Observações</span>
                                                </div>

                                                <label for="laudoTecnico" style="font-weight: 600; font-size: 12px; color: #cfcfe0; display: flex; justify-content: space-between; align-items: center;">
                                                    <span>Laudo Técnico / Diagnóstico da Bancada</span>
                                                    <button type="button" class="toggle-editor-btn" onclick="toggleTrumbowyg('laudoTecnico')"><i class="fas fa-edit"></i> Alternar Formatador</button>
                                                </label>
                                                <div class="os-quick-tags">
                                                    <span class="quick-tag-btn" onclick="addTextToField('laudoTecnico', 'Aparelho em testes na bancada. ')">+ Em testes</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('laudoTecnico', 'Necessário substituição de componentes danificados. ')">+ Troca de peça</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('laudoTecnico', 'Efetuada limpeza interna e troca de pasta térmica. ')">+ Limpeza/Pasta</span>
                                                    <span class="quick-tag-btn" onclick="addTextToField('laudoTecnico', 'Reinstalação do sistema operacional e testes de hardware concluídos. ')">+ Formatação OK</span>
                                                </div>
                                                <textarea class="modern-textarea editor-field" name="laudoTecnico" id="laudoTecnico" placeholder="Constatações técnicas, testes efetuados ou solução proposta..."></textarea>

                                                <div style="margin-top: 14px;">
                                                    <label for="observacoes" style="font-weight: 600; font-size: 12px; color: #cfcfe0; display: flex; justify-content: space-between; align-items: center;">
                                                        <span>Observações Internas / Avisos de Garantia</span>
                                                        <button type="button" class="toggle-editor-btn" onclick="toggleTrumbowyg('observacoes')"><i class="fas fa-edit"></i> Alternar Formatador</button>
                                                    </label>
                                                    <div class="os-quick-tags">
                                                        <span class="quick-tag-btn" onclick="addTextToField('observacoes', 'Cliente ciente do prazo de orçamento. ')">+ Ciente do prazo</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('observacoes', 'Lacre de garantia nº ')">+ Lacre Nº</span>
                                                        <span class="quick-tag-btn" onclick="addTextToField('observacoes', 'Aparelho entregue com teste de bancada na presença do cliente. ')">+ Testado na entrega</span>
                                                    </div>
                                                    <textarea class="modern-textarea editor-field" name="observacoes" id="observacoes" placeholder="Informações complementares, número de lacre ou avisos internos..."></textarea>
                                                </div>
                                            </div>
                                                     <div class="amura-form-actions" style="margin-top: 20px;">
                        <a href="<?php echo base_url() ?>index.php/os" class="btn-amura-secondary">
                            <i class="bx bx-x"></i> Cancelar
                        </a>
                        <button type="submit" class="btn-amura-primary" id="btnContinuar">
                            <i class='bx bx-chevrons-right'></i> Continuar para Itens da OS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });
        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 1,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });
        $("#termoGarantia").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteTermoGarantia",
            minLength: 1,
            select: function(event, ui) {
                $("#garantias_id").val(ui.item.id);
            }
        });

        $("#formOs").validate({
            rules: {
                cliente: {
                    required: true
                },
                tecnico: {
                    required: true
                },
                dataInicial: {
                    required: true
                },
                dataFinal: {
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
                dataInicial: {
                    required: 'Campo Requerido.'
                },
                dataFinal: {
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
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });

    function addTextToField(fieldId, text) {
        const field = document.getElementById(fieldId);
        if (!field) return;

        // Se Trumbowyg estiver ativo no campo
        if ($(field).data('trumbowyg')) {
            const currentHtml = $(field).trumbowyg('html');
            $(field).trumbowyg('html', currentHtml + ' ' + text);
        } else {
            const currentVal = field.value || '';
            field.value = currentVal ? currentVal.trim() + ' ' + text : text;
            field.focus();
        }
    }

    function toggleTrumbowyg(fieldId) {
        const $field = $('#' + fieldId);
        if ($field.data('trumbowyg')) {
            $field.trumbowyg('destroy');
        } else {
            $field.trumbowyg({
                lang: 'pt_br',
                semantic: { 'strikethrough': 's' },
                btns: [
                    ['formatting'],
                    ['strong', 'em', 'underline'],
                    ['unorderedList', 'orderedList'],
                    ['removeformat']
                ]
            });
        }
    }
</script>
