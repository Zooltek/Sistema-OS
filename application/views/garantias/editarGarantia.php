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
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Editar Termo de Garantia</h1>
                <p class="amura-header-subtitle">Atualize os termos e condições do modelo (ID #<?= $result->idGarantias ?>)</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/garantias'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <?php if ($custom_error) { ?>
        <div class="alert alert-danger" style="background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3); color: #fca5a5; border-radius: 6px; padding: 12px 16px;">
            Dados incompletos, por favor verifique os campos obrigatórios.
        </div>
    <?php } ?>

    <!-- Card do Formulário -->
    <div class="amura-form-card">
        <form action="<?php echo current_url(); ?>" method="post" id="formGarantia">
            <?php echo form_hidden('idGarantias', $result->idGarantias) ?>
            <div class="amura-form-section">
                <h3 class="amura-form-section-title">
                    <i class="bx bx-info-circle"></i> Informações Básicas
                </h3>

                <div style="display: grid; grid-template-columns: 140px 220px 1fr; gap: 14px; margin-bottom: 16px;">
                    <div class="control-group amura-form-group">
                        <label for="dataGarantia" class="control-label amura-form-label">Data</label>
                        <div class="controls">
                            <input id="dataGarantia" class="amura-form-input datepicker" type="text" name="dataGarantia" value="<?php echo date('d/m/Y', strtotime($result->dataGarantia)); ?>" disabled style="opacity: 0.7;" />
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="usuarios_id" class="control-label amura-form-label">Responsável</label>
                        <div class="controls">
                            <input id="usuarios_id" class="amura-form-input" type="text" name="usuarios_id" value="<?php echo html_escape($result->nome); ?>" disabled style="opacity: 0.7;" />
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="refGarantia" class="control-label amura-form-label">Referência da Garantia <span class="required">*</span></label>
                        <div class="controls">
                            <input id="refGarantia" type="text" class="amura-form-input" name="refGarantia" value="<?php echo html_escape($result->refGarantia); ?>" required />
                        </div>
                    </div>
                </div>

                <div class="control-group amura-form-group">
                    <label for="textoGarantia" class="control-label amura-form-label">Texto Integral do Termo de Garantia <span class="required">*</span></label>
                    <div class="controls" style="margin-top: 6px;">
                        <textarea required class="editor" name="textoGarantia" id="textoGarantia" cols="30" rows="8"><?php echo $result->textoGarantia ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="amura-form-actions">
                <a href="<?php echo base_url('index.php/garantias') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary">
                    <i class='bx bx-save'></i> Atualizar Termo de Garantia
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/garantias/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });
        $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/garantias/autoCompleteUsuario",
            minLength: 1,
            select: function(event, ui) {
                $("#usuarios_id").val(ui.item.id);
            }
        });
        $("#formGarantia").validate({
            rules: {
                refGarantia: { required: true },
                textoGarantia: { required: true }
            },
            messages: {
                refGarantia: { required: 'Campo Requerido.' },
                textoGarantia: { required: 'Preencha com o termo de garantia' }
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
    });
</script>
