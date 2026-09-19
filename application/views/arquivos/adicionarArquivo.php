<link rel="stylesheet" href="<?= base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-upload"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Adicionar Arquivo</h1>
                <p class="amura-header-subtitle">Faça upload de documentos, manuais, comprovantes ou fotos</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/arquivos'); ?>" class="btn-amura-secondary">
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
        <form action="<?= current_url() ?>" id="formArquivo" enctype="multipart/form-data" method="post">
            <div class="amura-form-section">
                <h3 class="amura-form-section-title">
                    <i class="bx bx-paperclip"></i> Informações do Documento
                </h3>

                <div class="control-group amura-form-group" style="margin-bottom: 14px;">
                    <label for="arquivo" class="control-label amura-form-label">Arquivo para Upload <span class="required">*</span></label>
                    <div class="controls" style="padding: 10px 14px; background: #0d1218; border: 1px dashed #334255; border-radius: 6px;">
                        <input id="arquivo" type="file" name="userfile" style="color: #cbd5e1;" />
                        <p style="margin: 6px 0 0 0; font-size: 0.78rem; color: #8c97a8;">Formatos suportados: .pdf, .txt, .png, .jpg, .jpeg, .gif</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px; margin-bottom: 14px;">
                    <div class="control-group amura-form-group">
                        <label for="nome" class="control-label amura-form-label">Nome do Arquivo / Título <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="amura-form-input" type="text" name="nome" placeholder="Ex: Manual do Equipamento" />
                        </div>
                    </div>
                    <div class="control-group amura-form-group">
                        <label for="data" class="control-label amura-form-label">Data de Registro</label>
                        <div class="controls">
                            <input id="data" type="text" class="amura-form-input datepicker" name="data" value="<?= date('d/m/Y') ?>" placeholder="dd/mm/aaaa" autocomplete="off" />
                        </div>
                    </div>
                </div>

                <div class="control-group amura-form-group">
                    <label for="descricao" class="control-label amura-form-label">Descrição / Observações</label>
                    <div class="controls">
                        <textarea class="amura-form-textarea" name="descricao" id="descricao" placeholder="Insira detalhes sobre o conteúdo deste arquivo..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="amura-form-actions">
                <a href="<?= base_url('index.php/arquivos') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary">
                    <i class='bx bx-upload'></i> Enviar Arquivo
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formArquivo').validate({
            rules: {
                nome: { required: true },
                userfile: { required: true }
            },
            messages: {
                nome: { required: 'Campo Requerido.' },
                userfile: { required: 'Selecione um arquivo.' }
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
    });
</script>
