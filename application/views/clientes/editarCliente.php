<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>

<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Editar Cliente / Fornecedor</h1>
                <p class="amura-header-subtitle">Atualize os dados cadastrais, endereço e preferências de contato (ID #<?= $result->idClientes ?>)</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= site_url('clientes'); ?>" class="btn-amura-secondary">
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
        <form action="<?php echo current_url(); ?>" id="formCliente" method="post">
            <?php echo form_hidden('idClientes', $result->idClientes) ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0;">
                <!-- Coluna 1: Dados Pessoais / Contato -->
                <div class="amura-form-section" style="border-right: 1px solid #1c2a38;">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-id-card"></i> Dados Principais & Contato
                    </h3>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="documento" class="control-label amura-form-label">CPF / CNPJ</label>
                        <div class="controls" style="display: flex; gap: 8px;">
                            <input id="documento" class="cpfcnpj amura-form-input" type="text" name="documento" value="<?php echo html_escape($result->documento); ?>" placeholder="000.000.000-00 ou 00.000.000/0000-00" />
                            <button id="buscar_info_cnpj" class="btn-amura-secondary" type="button" style="height: 36px; padding: 0 12px; font-size: 0.8rem;" title="Consultar dados via Receita">
                                <i class='bx bx-search'></i> Buscar CNPJ
                            </button>
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="nomeCliente" class="control-label amura-form-label">Nome / Razão Social <span class="required">*</span></label>
                        <div class="controls">
                            <input id="nomeCliente" class="amura-form-input" type="text" name="nomeCliente" value="<?php echo html_escape($result->nomeCliente); ?>" placeholder="Nome completo ou Razão Social" />
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="contato" class="control-label amura-form-label">Pessoa de Contato</label>
                        <div class="controls">
                            <input class="contato amura-form-input" id="contato" type="text" name="contato" value="<?php echo html_escape($result->contato); ?>" placeholder="Nome do responsável pelo contato" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="telefone" class="control-label amura-form-label">Telefone Fixo</label>
                            <div class="controls">
                                <input id="telefone" class="amura-form-input" type="text" name="telefone" value="<?php echo html_escape($result->telefone); ?>" placeholder="(00) 0000-0000" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="celular" class="control-label amura-form-label">Celular / WhatsApp</label>
                            <div class="controls">
                                <input id="celular" class="amura-form-input" type="text" name="celular" value="<?php echo html_escape($result->celular); ?>" placeholder="(00) 00000-0000" />
                            </div>
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="email" class="control-label amura-form-label">E-mail</label>
                        <div class="controls">
                            <input id="email" class="amura-form-input" type="text" name="email" value="<?php echo html_escape($result->email); ?>" placeholder="cliente@exemplo.com.br" />
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="senha" class="control-label amura-form-label">Senha (Acesso do Cliente)</label>
                        <div class="controls" style="position: relative;">
                            <input class="amura-form-input" id="senha" type="password" name="senha" value="" placeholder="Deixe em branco se não desejar alterar" style="padding-right: 38px !important;" />
                            <img id="imgSenha" src="<?php echo base_url() ?>assets/img/eye.svg" alt="" style="position: absolute; right: 10px; top: 9px; width: 18px; cursor: pointer; opacity: 0.7;" />
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 8px;">
                        <label class="control-label amura-form-label">Classificação do Cadastro</label>
                        <div class="controls" style="padding-top: 4px;">
                            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: #e2e8f0; font-size: 0.85rem; font-weight: 500;">
                                <input type="checkbox" id="fornecedor" name="fornecedor" value="1" <?php echo ($result->fornecedor == 1) ? 'checked' : ''; ?> style="width: 16px; height: 16px; margin: 0;">
                                Marcar também como <strong>Fornecedor</strong>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Endereço -->
                <div class="amura-form-section">
                    <h3 class="amura-form-section-title">
                        <i class="bx bx-map-pin"></i> Endereço & Localização
                    </h3>

                    <div style="display: grid; grid-template-columns: 140px 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="cep" class="control-label amura-form-label">CEP</label>
                            <div class="controls">
                                <input id="cep" class="amura-form-input" type="text" name="cep" value="<?php echo html_escape($result->cep); ?>" placeholder="00000-000" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="rua" class="control-label amura-form-label">Logradouro / Rua</label>
                            <div class="controls">
                                <input id="rua" class="amura-form-input" type="text" name="rua" value="<?php echo html_escape($result->rua); ?>" placeholder="Ex: Av. Paulista" />
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="numero" class="control-label amura-form-label">Número</label>
                            <div class="controls">
                                <input id="numero" class="amura-form-input" type="text" name="numero" value="<?php echo html_escape($result->numero); ?>" placeholder="123" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="complemento" class="control-label amura-form-label">Complemento</label>
                            <div class="controls">
                                <input id="complemento" class="amura-form-input" type="text" name="complemento" value="<?php echo html_escape($result->complemento); ?>" placeholder="Sala, Apto, Galpão..." />
                            </div>
                        </div>
                    </div>

                    <div class="control-group amura-form-group" style="margin-bottom: 12px;">
                        <label for="bairro" class="control-label amura-form-label">Bairro</label>
                        <div class="controls">
                            <input id="bairro" class="amura-form-input" type="text" name="bairro" value="<?php echo html_escape($result->bairro); ?>" placeholder="Nome do bairro" />
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 140px; gap: 10px; margin-bottom: 12px;">
                        <div class="control-group amura-form-group">
                            <label for="cidade" class="control-label amura-form-label">Cidade</label>
                            <div class="controls">
                                <input id="cidade" class="amura-form-input" type="text" name="cidade" value="<?php echo html_escape($result->cidade); ?>" placeholder="Nome da cidade" />
                            </div>
                        </div>
                        <div class="control-group amura-form-group">
                            <label for="estado" class="control-label amura-form-label">Estado (UF)</label>
                            <div class="controls">
                                <select id="estado" name="estado" class="amura-form-select">
                                    <option value="">Selecione...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="amura-form-actions">
                <a href="<?php echo site_url('clientes') ?>" class="btn-amura-secondary">
                    <i class="bx bx-x"></i> Cancelar
                </a>
                <button type="submit" class="btn-amura-primary">
                    <i class='bx bx-save'></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let input = document.querySelector('#senha');
        let icon = document.querySelector('#imgSenha');

        if (icon && input) {
            icon.addEventListener('click', function() {
                if (input.type === 'password') {
                    icon.src = '<?php echo base_url() ?>assets/img/eye-off.svg';
                    input.type = 'text';
                } else {
                    icon.src = '<?php echo base_url() ?>assets/img/eye.svg';
                    input.type = 'password';
                }
            });
        }

        $.getJSON('<?php echo base_url() ?>assets/json/estados.json', function(data) {
            for (var i in data.estados) {
                $('#estado').append(new Option(data.estados[i].nome, data.estados[i].sigla));
            }
            var curState = '<?php echo $result->estado; ?>';
            if (curState) {
                $("#estado option[value=" + curState + "]").prop("selected", true);
            }
        });

        $('#formCliente').validate({
            rules: {
                nomeCliente: {
                    required: true
                },
            },
            messages: {
                nomeCliente: {
                    required: 'Campo Requerido.'
                },
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
