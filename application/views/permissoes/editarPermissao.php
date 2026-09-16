
<style>
    .accordion-heading .widget-title {
        position: relative;
        padding: 0 !important;
        min-height: 40px;
    }

    .accordion-heading .widget-title a {
        display: flex;
        align-items: center;
        width: 100%;
        min-height: 40px;
        box-sizing: border-box;
        text-decoration: none;
        position: relative;
    }

    .accordion-heading .widget-title h5 {
        font-weight : 600;
        padding     : 0 !important;
        padding-left: 38px !important;
        line-height : 1.4 !important;
        margin      : 0 !important;
        font-size   : 14px;
        color       : var(--violeta1);
        white-space : nowrap !important;
        width       : auto !important;
    }

    .accordion-heading .icon-cli {
        color: #239683;
        font-size: 19px;
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
    }

    .accordion-heading .icon-clic {
        color: #9faab7;
        font-size: 1.6em;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
    }

    .accordion-heading a:hover .icon-clic {
        color: #3fadf6;
    }

    .widget-content {
        padding: 12px 15px;
    }

    .table td {
        padding: 8px;
    }

    .accordion table {
        width: 100%;
        table-layout: fixed;
        margin-bottom: 0;
    }

    .accordion .widget-box {
        margin-top   : 8px;
        margin-bottom: 0;
        border-radius: 6px;
    }

    .button {
        min-width: 130px;
    }

    .form-actions {
        padding: 15px 0 5px;
        margin-top: 20px;
        margin-bottom: 10px;
        background-color: transparent;
        border-top: 1px solid #e5e5e5;
    }

    .widget-content table tbody tr:hover {
        background: transparent;
    }

@media (max-width: 480px) {
    .widget-content {
        padding: 10px 7px !important;
    }
}
</style>

<?php $permissoes = json_decode_legacy($result->permissoes); ?>
<div class="span12" style="margin-left: 0">
    <form action="<?php echo base_url();?>index.php/permissoes/editar" id="formPermissao" method="post">
        <div class="span12" style="margin-left: 0">
            <div class="widget-box">
                <div class="widget-title" style="display: flex; align-items: center; justify-content: flex-start; gap: 8px; padding: 0 12px; min-height: 40px;">
                    <span class="icon"><i class="fas fa-lock"></i></span>
                    <h5 style="margin: 0; font-size: 14px; font-weight: 600;">Editar Permissão</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid" style="display: flex; flex-wrap: wrap; align-items: flex-end; gap: 15px; margin-bottom: 20px;">
                        <div style="flex: 2; min-width: 240px;">
                            <label for="nome" style="font-weight: 600; margin-bottom: 6px;">Nome da Permissão</label>
                            <input name="nome" type="text" id="nome" class="span12" style="margin-bottom: 0;" value="<?php echo $result->nome; ?>" />
                            <input type="hidden" name="idPermissao" value="<?php echo $result->idPermissao; ?>">
                        </div>
                        <div style="flex: 1; min-width: 160px;">
                            <label for="situacao" style="font-weight: 600; margin-bottom: 6px;">Situação</label>
                            <select name="situacao" id="situacao" class="span12" style="margin-bottom: 0;">
                                <option value="1" <?php echo $result->situacao == 1 ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?php echo $result->situacao == 0 ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                        <div style="flex: 1; min-width: 150px; padding-bottom: 8px;">
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 6px; margin: 0;">
                                <input name="" type="checkbox" value="1" id="marcarTodos" style="margin: 0;" />
                                <span class="lbl" style="font-weight: 600;"> Marcar Todos</span>
                            </label>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="accordion" id="collapse-group" style="width: 100%;">
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                <span><i class='bx bx-group icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Clientes</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse in accordion-body" id="collapseGOne">
                        <div class="widget-content">
                        <table class="table table-bordered">
                                <tr>
                                    <td colspan="4"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label......>
                                            <input <?php if (isset($permissoes['vCliente'])) {
                                                if ($permissoes['vCliente'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Cliente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aCliente'])) {
                                                if ($permissoes['aCliente'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Cliente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eCliente'])) {
                                                if ($permissoes['eCliente'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Cliente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dCliente'])) {
                                                if ($permissoes['dCliente'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Cliente</span>
                                        </label>
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                <span><i class='bx bx-package icon-cli'></i></span>
                                <h5 style="padding-left: 28px">Produtos</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGTwo">
                        <div class="widget-content">
                        <table class="table table-bordered">
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                            <tr>
                                <td>
                                    <label>
                                        <input <?php if (isset($permissoes['vProduto'])) {
                                            if ($permissoes['vProduto'] == '1') {
                                                echo 'checked';
                                            }
                                        }?> name="vProduto" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Produto</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aProduto'])) {
                                                if ($permissoes['aProduto'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aProduto" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Produto</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eProduto'])) {
                                                if ($permissoes['eProduto'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eProduto" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Produto</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dProduto'])) {
                                                if ($permissoes['dProduto'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dProduto" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Produto</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                <span><i class='bx bx-stopwatch icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Serviços</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGThree">
                        <div class="widget-content">
                        <table class="table table-bordered">
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vServico'])) {
                                                if ($permissoes['vServico'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Serviço</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aServico'])) {
                                                if ($permissoes['aServico'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Serviço</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eServico'])) {
                                                if ($permissoes['eServico'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Serviço</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dServico'])) {
                                                if ($permissoes['dServico'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Serviço</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGFour" data-toggle="collapse">
                                <span><i class='bx bx-spreadsheet icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Ordens de Serviço</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGFour">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vOs'])) {
                                                if ($permissoes['vOs'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar OS</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aOs'])) {
                                                if ($permissoes['aOs'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar OS</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eOs'])) {
                                                if ($permissoes['eOs'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar OS</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dOs'])) {
                                                if ($permissoes['dOs'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir OS</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGFive" data-toggle="collapse">
                                <span><i class='bx bx-cart-alt icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Vendas</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGFive">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vVenda'])) {
                                                if ($permissoes['vVenda'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vVenda" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Venda</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aVenda'])) {
                                                if ($permissoes['aVenda'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aVenda" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Venda</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eVenda'])) {
                                                if ($permissoes['eVenda'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eVenda" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Venda</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dVenda'])) {
                                                if ($permissoes['dVenda'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dVenda" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Venda</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGSix" data-toggle="collapse">
                                <span><i class='bx bx-credit-card-front icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Cobranças</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGSix">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vCobranca'])) {
                                                if ($permissoes['vCobranca'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vCobranca" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Cobranças</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aCobranca'])) {
                                                if ($permissoes['aCobranca'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aCobranca" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Cobranças</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eCobranca'])) {
                                                if ($permissoes['eCobranca'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eCobranca" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Cobranças</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dCobranca'])) {
                                                if ($permissoes['dCobranca'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dCobranca" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Cobranças</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGSeven" data-toggle="collapse">
                                <span><i class='bx bx-receipt icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Garantias</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGSeven">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vGarantia'])) {
                                                if ($permissoes['vGarantia'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vGarantia" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Garantia</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aGarantia'])) {
                                                if ($permissoes['aGarantia'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aGarantia" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Garantia</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eGarantia'])) {
                                                if ($permissoes['eGarantia'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eGarantia" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Garantia</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dGarantia'])) {
                                                if ($permissoes['dGarantia'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dGarantia" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Garantia</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGEight" data-toggle="collapse">
                                <span><i class='bx bx-box icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Arquivos</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGEight">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vArquivo'])) {
                                                if ($permissoes['vArquivo'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vArquivo" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Arquivo</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aArquivo'])) {
                                                if ($permissoes['aArquivo'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aArquivo" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Arquivo</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eArquivo'])) {
                                                if ($permissoes['eArquivo'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eArquivo" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Arquivo</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dArquivo'])) {
                                                if ($permissoes['dArquivo'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dArquivo" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Arquivo</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGNine" data-toggle="collapse">
                                <span><i class='bx bx-bar-chart-square icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Financeiro</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGNine">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['vLancamento'])) {
                                                if ($permissoes['vLancamento'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="vLancamento" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Visualizar Lançamento</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['aLancamento'])) {
                                                if ($permissoes['aLancamento'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="aLancamento" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Adicionar Lançamento</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['eLancamento'])) {
                                                if ($permissoes['eLancamento'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="eLancamento" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Editar Lançamento</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['dLancamento'])) {
                                                if ($permissoes['dLancamento'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="dLancamento" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Excluir Lançamento</span>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGTen" data-toggle="collapse">
                                <span><i class='bx bx-chart icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Relatórios</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGTen">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['rCliente'])) {
                                                if ($permissoes['rCliente'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="rCliente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Cliente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rServico'])) {
                                                if ($permissoes['rServico'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="rServico" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Serviço</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rOs'])) {
                                                if ($permissoes['rOs'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="rOs" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório OS</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rProduto'])) {
                                                if ($permissoes['rProduto'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="rProduto" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Produto</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rVenda'])) {
                                                if ($permissoes['rVenda'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="rVenda" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Venda</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['rFinanceiro'])) {
                                                if ($permissoes['rFinanceiro'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="rFinanceiro" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Relatório Financeiro</span>
                                        </label>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title">
                            <a data-parent="#collapse-group" href="#collapseGEleven" data-toggle="collapse">
                                <span><i class='bx bx-cog icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Configurações e Sistema</h5>
                                <span><i class='bx bx-chevron-right icon-clic'></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGEleven">
                        <div class="widget-content">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>
                                            <input <?php if (isset($permissoes['cUsuario'])) {
                                                if ($permissoes['cUsuario'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="cUsuario" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Configurar Usuário</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cEmitente'])) {
                                                if ($permissoes['cEmitente'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="cEmitente" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Configurar Emitente</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cPermissao'])) {
                                                if ($permissoes['cPermissao'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="cPermissao" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Configurar Permissão</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php if (isset($permissoes['cBackup'])) {
                                                if ($permissoes['cBackup'] == '1') {
                                                    echo 'checked';
                                                }
                                            }?> name="cBackup" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Backup</span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <input <?php echo (isset($permissoes['cAuditoria']) && $permissoes['cAuditoria'] == 1) ? 'checked' : ''; ?> name="cAuditoria" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Auditoria</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php echo (isset($permissoes['cEmail']) && $permissoes['cEmail'] == 1) ? 'checked' : ''; ?> name="cEmail" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Emails</span>
                                        </label>
                                    </td>
                                    <td>
                                        <label>
                                            <input <?php echo (isset($permissoes['cSistema']) && $permissoes['cSistema'] == 1) ? 'checked' : ''; ?> name="cSistema" class="marcar" type="checkbox" value="1" />
                                            <span class="lbl"> Sistema</span>
                                        </label>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="span12" style="display: flex; justify-content: center; gap: 12px; margin: 0;">
                    <button type="submit" class="button btn btn-primary">
                        <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar</span>
                    </button>
                    <a title="Voltar" class="button btn btn-mini btn-warning" href="<?php echo site_url() ?>/permissoes">
                        <span class="button__icon"><i class="bx bx-undo"></i></span> <span class="button__text2">Voltar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>


<script type="text/javascript" src="<?php echo base_url()?>assets/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#marcarTodos").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
        $("#formPermissao").validate({
            rules :{
                nome: {required: true}
            },
            messages:{
                nome: {required: 'Campo obrigatório'}
            }});
    });
</script>
