<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Editar Produto</h1>
                <p class="amura-header-subtitle">Atualize os dados, precificação e níveis de estoque (ID #<?= $result->idProdutos ?>)</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/produtos'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <?php if (!empty($custom_error)) { ?>
        <div class="alert alert-danger" style="background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3); color: #fca5a5; border-radius: 6px; padding: 12px 16px;">
            <?= $custom_error ?>
        </div>
    <?php } ?>

    <!-- Card do Formulário -->
    <div class="amura-form-card">
        <form action="<?php echo current_url(); ?>" id="formProduto" method="post">
            <?php echo form_hidden('idProdutos', $result->idProdutos) ?>
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 0;">
                <!-- Coluna 1: Identificação & Preços -->
                <div class="amura-form-section" style="border-right: 1px solid #1c2a38;">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-barcode"></i> Identificação do Produto
                    </h3>

                    <div style="display: grid; grid-template-columns: 180px 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="codDeBarra" class="control-label amura-form-label">Código de Barras</label>
                            <div class="controls">
                                <input id="codDeBarra" class="amura-form-input" type="text" name="codDeBarra" value="<?php echo html_escape($result->codDeBarra); ?>" placeholder="EAN ou código interno" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="descricao" class="control-label amura-form-label">Descrição / Nome do Produto <span class="required">*</span></label>
                            <div class="controls">
                                <input id="descricao" class="amura-form-input" type="text" name="descricao" value="<?php echo html_escape($result->descricao); ?>" placeholder="Nome completo do item" />
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="unidade" class="control-label amura-form-label">Unidade de Medida <span class="required">*</span></label>
                            <div class="controls">
                                <select id="unidade" name="unidade" class="amura-form-select"></select>
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label class="control-label amura-form-label">Tipo de Movimento</label>
                            <div class="controls" style="display: flex; gap: 14px; padding-top: 6px;">
                                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: #cbd5e1; font-size: 0.85rem;">
                                    <input type="checkbox" id="entrada" name="entrada" value="1" <?= ($result->entrada == 1) ? 'checked' : '' ?> style="margin: 0; width: 16px; height: 16px;"> Entrada
                                </label>
                                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: #cbd5e1; font-size: 0.85rem;">
                                    <input type="checkbox" id="saida" name="saida" value="1" <?= ($result->saida == 1) ? 'checked' : '' ?> style="margin: 0; width: 16px; height: 16px;"> Saída
                                </label>
                            </div>
                        </div>
                    </div>

                    <h3 class="amura-form-section-title" style="margin-top: 18px;">
                        <i class="bx bx-dollar-circle"></i> Formação de Preço
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="precoCompra" class="control-label amura-form-label">Preço Compra <span class="required">*</span></label>
                            <div class="controls">
                                <input id="precoCompra" class="money amura-form-input" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoCompra" value="<?php echo $result->precoCompra; ?>" placeholder="0.00" />
                                <span style="color: #f87171; font-size: 0.75rem;" id="errorAlert"></span>
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="Lucro" class="control-label amura-form-label">Tipo / Margem (%)</label>
                            <div class="controls" style="display: flex; gap: 6px;">
                                <select id="selectLucro" name="selectLucro" class="amura-form-select" style="flex: 1.4; padding: 4px 6px !important;">
                                    <option value="markup">Markup</option>
                                    <option value="margemLucro">Margem</option>
                                </select>
                                <input id="Lucro" name="Lucro" class="amura-form-input" type="text" placeholder="%" maxlength="3" style="flex: 0.8; text-align: center;" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="precoVenda" class="control-label amura-form-label">Preço Venda <span class="required">*</span></label>
                            <div class="controls">
                                <input id="precoVenda" class="money amura-form-input" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoVenda" value="<?php echo $result->precoVenda; ?>" placeholder="0.00" style="font-weight: 700; color: #4ade80 !important;" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Estoque & Parâmetros -->
                <div class="amura-form-section">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-cube"></i> Controle de Estoque
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="estoque" class="control-label amura-form-label">Estoque Atual <span class="required">*</span></label>
                            <div class="controls">
                                <input id="estoque" class="amura-form-input" type="text" name="estoque" value="<?php echo $result->estoque; ?>" placeholder="Quantidade em estoque" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="estoqueMinimo" class="control-label amura-form-label">Estoque Mínimo</label>
                            <div class="controls">
                                <input id="estoqueMinimo" class="amura-form-input" type="text" name="estoqueMinimo" value="<?php echo $result->estoqueMinimo; ?>" placeholder="Alerta de reposição" />
                            </div>
                        </div>
                    </div>

                    <div style="background: rgba(255,146,4,0.06); border: 1px solid rgba(255,146,4,0.18); border-radius: 6px; padding: 14px; margin-top: 14px; font-size: 0.82rem; color: #94a3b8; line-height: 1.5;">
                        <strong style="color: #ff9204;"><i class='bx bx-info-circle'></i> Regras de Cálculo:</strong>
                        <ul style="margin: 6px 0 0 16px; padding: 0;">
                            <li><strong>Markup:</strong> Percentual aplicado diretamente sobre o preço de compra.</li>
                            <li><strong>Margem de Lucro:</strong> Percentual de margem calculada sobre o preço final de venda.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="amura-form-actions">
                <a href="<?php echo base_url('index.php/produtos') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary">
                    <i class='bx bx-save'></i> Atualizar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    function calcLucro(precoCompra, Lucro) {
        var lucroTipo = $('#selectLucro').val();
        var precoVenda;
        
        if (lucroTipo === 'markup') {
            precoVenda = (precoCompra * (1 + Lucro / 100)).toFixed(2);
        } else if (lucroTipo === 'margemLucro') {
            precoVenda = (precoCompra / (1 - (Lucro / 100))).toFixed(2);
        }
        
        return precoVenda;
    }
    
    function atualizarPrecoVenda() {
        var precoCompra = Number($("#precoCompra").val());
        var lucro = Number($("#Lucro").val());
        
        if (precoCompra > 0 && lucro > 0) {
            var precoVenda = calcLucro(precoCompra, lucro);
            $("#precoVenda").val(precoVenda);
        }
    }

    function atualizarLucro() {
        var precoCompra = Number($("#precoCompra").val());
        var precoVenda = Number($("#precoVenda").val());
        var lucroTipo = $('#selectLucro').val();
        
        if (precoCompra > 0 && precoVenda > 0) {
            var lucro;
            if (lucroTipo === 'markup') {
                lucro = (((precoVenda - precoCompra) / precoCompra) * 100).toFixed(1);
            } else if (lucroTipo === 'margemLucro') {
                lucro = (((precoVenda - precoCompra) / precoVenda) * 100).toFixed(1);
            }
            if (!isNaN(lucro)) {
                $("#Lucro").val(lucro);
            }
        }
    }

    $(document).ready(function() {
        $(".money").maskMoney();
        
        $.getJSON('<?php echo base_url() ?>assets/json/unidades.json', function(data) {
            for (var i in data) {
                $("#unidade").append(new Option(data[i].descricao, data[i].unidade));
            }
            var curUnit = '<?php echo $result->unidade; ?>';
            if (curUnit) {
                $("#unidade option[value=" + curUnit + "]").prop("selected", true);
            }
        });

        $('#selectLucro').change(function() {
            atualizarPrecoVenda();
        });

        $('#precoCompra, #Lucro').keyup(function() {
            atualizarPrecoVenda();
        });

        $('#precoVenda').keyup(function() {
            atualizarLucro();
        });

        $('#formProduto').validate({
            rules: {
                descricao: {
                    required: true
                },
                unidade: {
                    required: true
                },
                precoCompra: {
                    required: true
                },
                precoVenda: {
                    required: true
                },
                estoque: {
                    required: true
                }
            },
            messages: {
                descricao: {
                    required: 'Campo Requerido.'
                },
                unidade: {
                    required: 'Campo Requerido.'
                },
                precoCompra: {
                    required: 'Campo Requerido.'
                },
                precoVenda: {
                    required: 'Campo Requerido.'
                },
                estoque: {
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
            }
        });
    });
</script>
