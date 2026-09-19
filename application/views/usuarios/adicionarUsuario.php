<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Adicionar Usuário</h1>
                <p class="amura-header-subtitle">Cadastre um novo operador ou administrador com perfil de acesso e validade</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/usuarios'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar para Lista
            </a>
        </div>
    </div>

    <?php if ($custom_error != '') { ?>
        <div class="alert alert-danger" style="background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3); color: #fca5a5; border-radius: 6px; padding: 12px 16px;">
            <?= $custom_error ?>
        </div>
    <?php } ?>

    <!-- Card do Formulário -->
    <div class="amura-form-card">
        <form action="<?php echo current_url(); ?>" id="formUsuario" method="post">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0;">
                <!-- Coluna 1: Dados Pessoais & Credenciais -->
                <div class="amura-form-section" style="border-right: 1px solid #1c2a38;">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-user"></i> Dados Pessoais & Acesso
                    </h3>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="nome" class="control-label amura-form-label">Nome Completo <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="amura-form-input" type="text" name="nome" value="<?php echo set_value('nome'); ?>" placeholder="Nome do colaborador" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="rg" class="control-label amura-form-label">RG <span class="required">*</span></label>
                            <div class="controls">
                                <input id="rg" class="amura-form-input" type="text" name="rg" value="<?php echo set_value('rg'); ?>" placeholder="00.000.000-0" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="cpfUser" class="control-label amura-form-label">CPF <span class="required">*</span></label>
                            <div class="controls">
                                <input class="amura-form-input cpfUser" type="text" id="cpfUser" name="cpf" value="<?php echo set_value('cpf'); ?>" placeholder="000.000.000-00" />
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="telefone" class="control-label amura-form-label">Telefone <span class="required">*</span></label>
                            <div class="controls">
                                <input id="telefone" class="amura-form-input" type="text" name="telefone" value="<?php echo set_value('telefone'); ?>" placeholder="(00) 0000-0000" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="celular" class="control-label amura-form-label">Celular</label>
                            <div class="controls">
                                <input id="celular" class="amura-form-input" type="text" name="celular" value="<?php echo set_value('celular'); ?>" placeholder="(00) 00000-0000" />
                            </div>
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="email" class="control-label amura-form-label">E-mail <span class="required">*</span></label>
                        <div class="controls">
                            <input id="email" class="amura-form-input" type="text" name="email" value="<?php echo set_value('email'); ?>" placeholder="usuario@empresa.com.br" />
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="senha" class="control-label amura-form-label">Senha Inicial <span class="required">*</span></label>
                        <div class="controls">
                            <input id="senha" class="amura-form-input" type="password" name="senha" value="<?php echo set_value('senha'); ?>" placeholder="Defina a senha de acesso" />
                        </div>
                    </div>

                    <h3 class="amura-form-section-title" style="margin-top: 18px;">
                        <i class="bx bx-shield"></i> Permissões & Validade
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label class="control-label amura-form-label">Perfil de Acesso <span class="required">*</span></label>
                            <div class="controls">
                                <select name="permissoes_id" id="permissoes_id" class="amura-form-select">
                                    <?php foreach ($permissoes as $p) {
                                        echo '<option value="' . $p->idPermissao . '">' . html_escape($p->nome) . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label class="control-label amura-form-label">Situação <span class="required">*</span></label>
                            <div class="controls">
                                <select name="situacao" id="situacao" class="amura-form-select">
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group amura-form-group">
                        <label for="dataExpiracao" class="control-label amura-form-label">Data de Expiração do Acesso <span class="required">*</span></label>
                        <div class="controls">
                            <input id="dataExpiracao" class="amura-form-input" type="date" name="dataExpiracao" value="<?php echo set_value('dataExpiracao'); ?>" />
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Endereço -->
                <div class="amura-form-section">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-map"></i> Endereço Residencial
                    </h3>

                    <div style="display: grid; grid-template-columns: 140px 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="cep" class="control-label amura-form-label">CEP <span class="required">*</span></label>
                            <div class="controls">
                                <input id="cep" class="amura-form-input" type="text" name="cep" value="<?php echo set_value('cep'); ?>" placeholder="00000-000" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="rua" class="control-label amura-form-label">Rua / Logradouro <span class="required">*</span></label>
                            <div class="controls">
                                <input id="rua" class="amura-form-input" type="text" name="rua" value="<?php echo set_value('rua'); ?>" placeholder="Nome da rua" />
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="numero" class="control-label amura-form-label">Número <span class="required">*</span></label>
                            <div class="controls">
                                <input id="numero" class="amura-form-input" type="text" name="numero" value="<?php echo set_value('numero'); ?>" placeholder="123" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="bairro" class="control-label amura-form-label">Bairro <span class="required">*</span></label>
                            <div class="controls">
                                <input id="bairro" class="amura-form-input" type="text" name="bairro" value="<?php echo set_value('bairro'); ?>" placeholder="Bairro" />
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 140px; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="cidade" class="control-label amura-form-label">Cidade <span class="required">*</span></label>
                            <div class="controls">
                                <input id="cidade" class="amura-form-input" type="text" name="cidade" value="<?php echo set_value('cidade'); ?>" placeholder="Cidade" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="estado" class="control-label amura-form-label">Estado (UF) <span class="required">*</span></label>
                            <div class="controls">
                                <input id="estado" class="amura-form-input" type="text" name="estado" value="<?php echo set_value('estado'); ?>" placeholder="SP, RJ..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="amura-form-actions">
                <a href="<?php echo base_url('index.php/usuarios') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Salvar Usuário
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formUsuario').validate({
            rules: {
                nome: { required: true },
                dataExpiracao: { required: true },
                cpf: { required: true },
                telefone: { required: true },
                email: { required: true },
                senha: { required: true },
                rua: { required: true },
                numero: { required: true },
                bairro: { required: true },
                cidade: { required: true },
                estado: { required: true },
                cep: { required: true }
            },
            messages: {
                nome: { required: 'Campo Requerido.' },
                dataExpiracao: { required: 'Campo Requerido.' },
                cpf: { required: 'Campo Requerido.' },
                telefone: { required: 'Campo Requerido.' },
                email: { required: 'Campo Requerido.' },
                senha: { required: 'Campo Requerido.' },
                rua: { required: 'Campo Requerido.' },
                numero: { required: 'Campo Requerido.' },
                bairro: { required: 'Campo Requerido.' },
                cidade: { required: 'Campo Requerido.' },
                estado: { required: 'Campo Requerido.' },
                cep: { required: 'Campo Requerido.' }
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
    });
</script>
