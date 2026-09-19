<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Adicionar Serviço</h1>
                <p class="amura-header-subtitle">Cadastre um novo serviço prestado ou modalidade de mão de obra</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/servicos'); ?>" class="btn-amura-secondary">
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
    <div class="amura-form-card" style="max-width: 800px; margin: 0 auto; width: 100%;">
        <form action="<?php echo current_url(); ?>" id="formServico" method="post">
            <div class="amura-form-section">
                <h3 class="amura-form-section-title">
                    <i class="bx bx-cog"></i> Detalhes do Serviço
                </h3>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px; margin-bottom: 14px;">
                    <div class="control-group amura-form-group">
                        <label for="nome" class="control-label amura-form-label">Nome do Serviço <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="amura-form-input" type="text" name="nome" value="<?php echo set_value('nome'); ?>" placeholder="Ex: Manutenção Preventiva" />
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="preco" class="control-label amura-form-label">Preço Sugerido (R$) <span class="required">*</span></label>
                        <div class="controls">
                            <input id="preco" class="money amura-form-input" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="preco" value="<?php echo set_value('preco'); ?>" placeholder="0.00" style="font-weight: 700; color: #4ade80 !important;" />
                        </div>
                    </div>
                </div>

                <div class="control-group amura-form-group">
                    <label for="descricao" class="control-label amura-form-label">Descrição dos Procedimentos</label>
                    <div class="controls">
                        <textarea id="descricao" class="amura-form-textarea" name="descricao" placeholder="Descreva os itens inclusos neste serviço..."><?php echo set_value('descricao'); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="amura-form-actions">
                <a href="<?php echo base_url('index.php/servicos') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Adicionar Serviço
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".money").maskMoney();
        $('#formServico').validate({
            rules: {
                nome: {
                    required: true
                },
                preco: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: 'Campo Requerido.'
                },
                preco: {
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
