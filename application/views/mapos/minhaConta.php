<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Minha Conta</h1>
                <p class="amura-header-subtitle">Visualize seus dados de operador e atualize sua senha de acesso</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <!-- Card 1: Perfil do Usuário -->
        <div class="amura-form-card">
            <div class="amura-form-section">
                <h3 class="amura-form-section-title">
                    <i class="bx bx-user"></i> Informações do Perfil
                </h3>

                <div class="profile-avatar-card">
                    <div style="position: relative; width: 80px; height: 80px; flex-shrink: 0;">
                        <img src="<?= (!$usuario->url_image_user || !is_file(FCPATH . "assets/userImage/" . $usuario->url_image_user)) ? base_url() . "assets/img/User.png" : base_url() . "assets/userImage/" . $usuario->url_image_user ?>" alt="Foto" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #ff9204;" />
                        <a href="#modalImageUser" data-toggle="modal" role="button" style="position: absolute; bottom: 0; right: 0; background: #ff9204; color: #fff; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none;" title="Alterar Foto">
                            <i class='bx bxs-camera'></i>
                        </a>
                    </div>
                    <div>
                        <h4 class="profile-user-name"><?= html_escape($usuario->nome) ?></h4>
                        <p class="profile-user-email"><?= html_escape($usuario->email) ?></p>
                        <span class="amura-badge amura-badge-purple" style="margin-top: 6px;"><?= html_escape($usuario->permissao) ?></span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div class="profile-info-row">
                        <span class="profile-info-label"><i class='bx bx-phone'></i> Telefone:</span>
                        <strong class="profile-info-val"><?= html_escape($usuario->telefone) ?: 'Não informado' ?></strong>
                    </div>
                    <div class="profile-info-row">
                        <span class="profile-info-label"><i class='bx bx-calendar'></i> Acesso Expira em:</span>
                        <strong style="color: #4ade80;"><?= date('d/m/Y', strtotime($usuario->dataExpiracao)) ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Alterar Senha -->
        <div class="amura-form-card">
            <form id="formSenha" action="<?= site_url('sistema/alterarSenha'); ?>" method="post">
                <div class="amura-form-section">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-lock-alt"></i> Alterar Senha de Acesso
                    </h3>

                    <div class="control-group amura-form-group" style="margin-bottom: 14px;">
                        <label for="oldSenha" class="control-label amura-form-label">Senha Atual <span class="required">*</span></label>
                        <div class="controls">
                            <input type="password" id="oldSenha" name="oldSenha" class="amura-form-input" placeholder="Digite sua senha atual" />
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 14px;">
                        <label for="novaSenha" class="control-label amura-form-label">Nova Senha <span class="required">*</span></label>
                        <div class="controls">
                            <input type="password" id="novaSenha" name="novaSenha" class="amura-form-input" placeholder="Digite a nova senha" />
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 14px;">
                        <label for="confirmarSenha" class="control-label amura-form-label">Confirmar Nova Senha <span class="required">*</span></label>
                        <div class="controls">
                            <input type="password" id="confirmarSenha" name="confirmarSenha" class="amura-form-input" placeholder="Repita a nova senha" />
                        </div>
                    </div>
                </div>

                <div class="amura-form-actions">
                    <button type="submit" class="btn-amura-primary">
                        <i class='bx bx-check-shield'></i> Atualizar Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Foto Usuário -->
<div id="modalImageUser" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?= site_url('sistema/uploadUserImage'); ?>" id="formImageUser" enctype="multipart/form-data" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bxs-camera" style="color: #ff9204; margin-right: 6px;"></i> Atualizar Foto do Usuário</h5>
        </div>
        <div class="modal-body">
            <div style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.25); color: #93c5fd; padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; font-size: 0.84rem;">
                <i class="bx bx-info-circle"></i> Selecione uma nova imagem (formato quadrado recomendado, 130 x 130 px).
            </div>
            <div class="control-group amura-form-group">
                <label for="userfile" class="control-label amura-form-label">Arquivo de Foto <span class="required">*</span></label>
                <div class="controls">
                    <input type="file" name="userfile" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-primary">
                <i class="bx bx-upload"></i> Enviar Foto
            </button>
        </div>
    </form>
</div>

<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#formImageUser").validate({
            rules: { userfile: { required: true } },
            messages: { userfile: { required: 'Campo Requerido.' } },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
            }
        });

        $('#formSenha').validate({
            rules: {
                oldSenha: { required: true },
                novaSenha: { required: true },
                confirmarSenha: { equalTo: "#novaSenha" }
            },
            messages: {
                oldSenha: { required: 'Campo Requerido.' },
                novaSenha: { required: 'Campo Requerido.' },
                confirmarSenha: { equalTo: 'As senhas não conferem.' }
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
