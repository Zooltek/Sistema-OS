<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Adicionar Produto</h1>
                <p class="amura-header-subtitle">Cadastre detalhes completos do produto, parâmetros de custo, margem de lucro e localização de estoque</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/produtos'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <?php if (!empty($custom_error)) { ?>
        <div class="alert alert-danger" style="background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3); color: #fca5a5; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px;">
            <?= $custom_error ?>
        </div>
    <?php } ?>

    <!-- Card do Formulário -->
    <div class="amura-form-card">
        <form action="<?php echo current_url(); ?>" id="formProduto" method="post">
            <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 0;">
                <!-- Coluna 1: Identificação, Classificação & Precificação -->
                <div class="amura-form-section" style="border-right: 1px solid #1c2a38;">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-barcode"></i> Identificação do Produto
                    </h3>

                    <!-- Código de Barras e Descrição -->
                    <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px; margin-bottom: 14px;">
                        <div class="control-group amura-form-group">
                            <label for="codDeBarra" class="control-label amura-form-label">Código de Barras</label>
                            <div class="controls" style="display: flex; gap: 6px;">
                                <input id="codDeBarra" class="amura-form-input" type="text" name="codDeBarra" value="<?php echo set_value('codDeBarra'); ?>" placeholder="EAN ou código interno" style="flex: 1;" />
                                <button type="button" id="btnGerarCodigo" class="btn-amura-secondary" title="Gerar código aleatório de 13 dígitos" style="padding: 0 10px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-refresh" style="font-size: 1.1rem;"></i>
                                </button>
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="descricao" class="control-label amura-form-label">Descrição / Nome do Produto <span class="required">*</span></label>
                            <div class="controls">
                                <input id="descricao" class="amura-form-input" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>" placeholder="Nome completo do item ou peça" />
                            </div>
                        </div>
                    </div>

                    <!-- Categoria, Marca e Modelo -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div class="control-group amura-form-group">
                            <label for="categoria" class="control-label amura-form-label">Categoria</label>
                            <div class="controls">
                                <input id="categoria" list="sugestoes-categorias" class="amura-form-input" type="text" name="categoria" value="<?php echo set_value('categoria'); ?>" placeholder="Ex: Peças, Acessórios" />
                                <datalist id="sugestoes-categorias">
                                    <option value="Peças e Componentes">
                                    <option value="Acessórios">
                                    <option value="Consumíveis">
                                    <option value="Hardware">
                                    <option value="Ferramentas">
                                    <option value="Geral">
                                </datalist>
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="marca" class="control-label amura-form-label">Marca / Fabricante</label>
                            <div class="controls">
                                <input id="marca" class="amura-form-input" type="text" name="marca" value="<?php echo set_value('marca'); ?>" placeholder="Ex: Dell, Samsung, Bosch" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="modelo" class="control-label amura-form-label">Modelo</label>
                            <div class="controls">
                                <input id="modelo" class="amura-form-input" type="text" name="modelo" value="<?php echo set_value('modelo'); ?>" placeholder="Ex: T140, SM-G991" />
                            </div>
                        </div>
                    </div>

                    <!-- Unidade de Medida, Código de Identificação (IMEI / Série) e Tipo de Movimento -->
                    <div style="display: grid; grid-template-columns: 140px 1.25fr 1fr; gap: 12px; margin-bottom: 14px; align-items: start;">
                        <div class="control-group amura-form-group">
                            <label for="unidade" class="control-label amura-form-label">Unidade <span class="required">*</span></label>
                            <div class="controls">
                                <select id="unidade" name="unidade" class="amura-form-select">
                                    <option value="UN" <?= set_value('unidade', 'UN') == 'UN' ? 'selected' : '' ?>>UN - Unidade</option>
                                    <option value="PC" <?= set_value('unidade') == 'PC' ? 'selected' : '' ?>>PC - Peça</option>
                                    <option value="CX" <?= set_value('unidade') == 'CX' ? 'selected' : '' ?>>CX - Caixa</option>
                                    <option value="KG" <?= set_value('unidade') == 'KG' ? 'selected' : '' ?>>KG - Quilo</option>
                                    <option value="GR" <?= set_value('unidade') == 'GR' ? 'selected' : '' ?>>GR - Grama</option>
                                    <option value="MT" <?= set_value('unidade') == 'MT' ? 'selected' : '' ?>>MT - Metro</option>
                                    <option value="CM" <?= set_value('unidade') == 'CM' ? 'selected' : '' ?>>CM - Centímetro</option>
                                    <option value="LT" <?= set_value('unidade') == 'LT' ? 'selected' : '' ?>>LT - Litro</option>
                                    <option value="ML" <?= set_value('unidade') == 'ML' ? 'selected' : '' ?>>ML - Mililitro</option>
                                    <option value="PAR" <?= set_value('unidade') == 'PAR' ? 'selected' : '' ?>>PAR - Par</option>
                                    <option value="JG" <?= set_value('unidade') == 'JG' ? 'selected' : '' ?>>JG - Jogo</option>
                                    <option value="KIT" <?= set_value('unidade') == 'KIT' ? 'selected' : '' ?>>KIT - Kit</option>
                                    <option value="FD" <?= set_value('unidade') == 'FD' ? 'selected' : '' ?>>FD - Fardo</option>
                                    <option value="RL" <?= set_value('unidade') == 'RL' ? 'selected' : '' ?>>RL - Rolo</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="codigo_identificacao" class="control-label amura-form-label">Cód. Identificação (IMEI / Série)</label>
                            <div class="controls">
                                <input id="codigo_identificacao" class="amura-form-input" type="text" name="codigo_identificacao" value="<?php echo set_value('codigo_identificacao'); ?>" placeholder="Ex: IMEI, Nº de Série, Chave..." />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label class="control-label amura-form-label">Permissões de Movimento</label>
                            <div class="controls" style="display: flex; gap: 14px; padding-top: 6px;">
                                <label style="display: flex; align-items: center; gap: 5px; cursor: pointer; color: #cbd5e1; font-size: 0.82rem;">
                                    <input type="checkbox" id="entrada" name="entrada" value="1" checked style="margin: 0; width: 15px; height: 15px;"> Entrada
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px; cursor: pointer; color: #cbd5e1; font-size: 0.82rem;">
                                    <input type="checkbox" id="saida" name="saida" value="1" checked style="margin: 0; width: 15px; height: 15px;"> Saída
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Seção de Preços -->
                    <h3 class="amura-form-section-title" style="margin-top: 22px;">
                        <i class="bx bx-dollar-circle"></i> Formação de Preço
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div class="control-group amura-form-group">
                            <label for="precoCompra" class="control-label amura-form-label">Preço Compra (Custo) <span class="required">*</span></label>
                            <div class="controls">
                                <input id="precoCompra" class="money amura-form-input" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoCompra" value="<?php echo set_value('precoCompra'); ?>" placeholder="0.00" />
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
                            <label for="precoVenda" class="control-label amura-form-label">Preço Venda (Final) <span class="required">*</span></label>
                            <div class="controls">
                                <input id="precoVenda" class="money amura-form-input" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoVenda" value="<?php echo set_value('precoVenda'); ?>" placeholder="0.00" style="font-weight: 700; color: #4ade80 !important;" />
                            </div>
                        </div>
                    </div>

                    <!-- Card Indicador de Rentabilidade em Tempo Real -->
                    <div id="cardRentabilidade" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 146, 4, 0.2); border-radius: 8px; padding: 14px 16px; margin-top: 10px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-size: 0.8rem; font-weight: 600; color: #ff9204; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="bx bx-trending-up"></i> Indicadores de Rentabilidade Estimada
                            </span>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; text-align: center;">
                            <div style="background: rgba(15, 23, 42, 0.5); padding: 8px 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                                <div style="font-size: 0.72rem; color: #94a3b8;">Lucro Bruto Unitário</div>
                                <div id="lblLucroBruto" style="font-size: 1.05rem; font-weight: 700; color: #4ade80; margin-top: 2px;">R$ 0,00</div>
                            </div>
                            <div style="background: rgba(15, 23, 42, 0.5); padding: 8px 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                                <div style="font-size: 0.72rem; color: #94a3b8;">Margem Real</div>
                                <div id="lblMargemReal" style="font-size: 1.05rem; font-weight: 700; color: #38bdf8; margin-top: 2px;">0.0%</div>
                            </div>
                            <div style="background: rgba(15, 23, 42, 0.5); padding: 8px 10px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05);">
                                <div style="font-size: 0.72rem; color: #94a3b8;">Markup Aplicado</div>
                                <div id="lblMarkupReal" style="font-size: 1.05rem; font-weight: 700; color: #f59e0b; margin-top: 2px;">0.0%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Estoque, Armazenagem, Garantia & Observações -->
                <div class="amura-form-section">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-cube"></i> Estoque & Armazenagem
                    </h3>

                    <!-- Estoque Inicial e Mínimo -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div class="control-group amura-form-group">
                            <label for="estoque" class="control-label amura-form-label">Estoque Inicial <span class="required">*</span></label>
                            <div class="controls">
                                <input id="estoque" class="amura-form-input" type="text" name="estoque" value="<?php echo set_value('estoque'); ?>" placeholder="Qtd inicial em estoque" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="estoqueMinimo" class="control-label amura-form-label">Estoque Mínimo</label>
                            <div class="controls">
                                <input id="estoqueMinimo" class="amura-form-input" type="text" name="estoqueMinimo" value="<?php echo set_value('estoqueMinimo'); ?>" placeholder="Alerta de reposição" />
                            </div>
                        </div>
                    </div>

                    <!-- Localização Física e Prazo de Garantia -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                        <div class="control-group amura-form-group">
                            <label for="localizacao" class="control-label amura-form-label">Localização no Estoque</label>
                            <div class="controls">
                                <input id="localizacao" class="amura-form-input" type="text" name="localizacao" value="<?php echo set_value('localizacao'); ?>" placeholder="Ex: Prateleira B, Gaveta 4" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="garantia" class="control-label amura-form-label">Prazo de Garantia</label>
                            <div class="controls">
                                <input id="garantia" list="sugestoes-garantias" class="amura-form-input" type="text" name="garantia" value="<?php echo set_value('garantia'); ?>" placeholder="Ex: 90 dias, 12 meses" />
                                <datalist id="sugestoes-garantias">
                                    <option value="Sem Garantia">
                                    <option value="30 dias">
                                    <option value="90 dias">
                                    <option value="6 meses">
                                    <option value="12 meses">
                                    <option value="2 anos">
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <!-- Observações / Especificações Técnicas -->
                    <div class="control-group amura-form-group" style="margin-top: 14px;">
                        <label for="observacoes" class="control-label amura-form-label">
                            <i class="bx bx-notepad"></i> Especificações & Observações Técnicas
                        </label>
                        <div class="controls">
                            <textarea id="observacoes" name="observacoes" class="amura-form-input" rows="4" style="resize: vertical; min-height: 85px;" placeholder="Detalhes técnicos, compatibilidade com aparelhos, notas de fornecedor ou especificações..."><?php echo set_value('observacoes'); ?></textarea>
                        </div>
                    </div>

                    <!-- Box de Instrução Visual -->
                    <div style="background: rgba(255,146,4,0.06); border: 1px solid rgba(255,146,4,0.18); border-radius: 6px; padding: 12px 14px; margin-top: 14px; font-size: 0.8rem; color: #94a3b8; line-height: 1.5;">
                        <strong style="color: #ff9204;"><i class='bx bx-info-circle'></i> Regras de Cálculo:</strong>
                        <ul style="margin: 4px 0 0 16px; padding: 0;">
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
                    <i class='bx bx-plus-circle'></i> Salvar Produto
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
        atualizarPainelRentabilidade();
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
        atualizarPainelRentabilidade();
    }

    function atualizarPainelRentabilidade() {
        var precoCompra = Number($("#precoCompra").val()) || 0;
        var precoVenda = Number($("#precoVenda").val()) || 0;
        
        if (precoVenda > 0 && precoCompra > 0) {
            var lucroBruto = (precoVenda - precoCompra);
            var margem = ((lucroBruto / precoVenda) * 100);
            var markup = ((lucroBruto / precoCompra) * 100);

            $("#lblLucroBruto").text("R$ " + lucroBruto.toFixed(2).replace('.', ','));
            $("#lblMargemReal").text(margem.toFixed(1) + "%");
            $("#lblMarkupReal").text(markup.toFixed(1) + "%");
            
            if (lucroBruto < 0) {
                $("#lblLucroBruto").css('color', '#f87171');
            } else {
                $("#lblLucroBruto").css('color', '#4ade80');
            }
        } else {
            $("#lblLucroBruto").text("R$ 0,00").css('color', '#4ade80');
            $("#lblMargemReal").text("0.0%");
            $("#lblMarkupReal").text("0.0%");
        }
    }

    function gerarCodigoBarras() {
        // Gerador de código padrão EAN-13 numérico
        var code = "789" + Math.floor(100000000 + Math.random() * 900000000);
        $("#codDeBarra").val(code);
    }

    $(document).ready(function() {
        $(".money").maskMoney();
        
        var curUnit = '<?php echo set_value('unidade', 'UN'); ?>';
        if (curUnit) {
            $("#unidade").val(curUnit);
        }

        $('#btnGerarCodigo').click(function() {
            gerarCodigoBarras();
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

        atualizarPainelRentabilidade();

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
