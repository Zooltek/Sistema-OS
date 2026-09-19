<?php $totalProdutos = 0; ?>
<div class="amura-page">
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Termo de Garantia #<?php echo $result->idGarantias; ?></h1>
                <p class="amura-header-subtitle">Referência: <strong><?php echo htmlspecialchars($result->refGarantia); ?></strong> | Responsável: <?php echo htmlspecialchars($result->nome); ?></p>
            </div>
        </div>
        <div class="amura-header-actions" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eGarantia')) { ?>
                <a title="Editar Termo de Garantia" class="btn-amura-primary" href="<?php echo base_url() . 'index.php/garantias/editar/' . $result->idGarantias; ?>">
                    <i class="bx bx-edit"></i> Editar
                </a>
            <?php } ?>
            <a target="_blank" title="Imprimir" class="btn-amura-secondary" href="<?php echo site_url() ?>/garantias/imprimir/<?php echo $result->idGarantias; ?>">
                <i class="bx bx-printer"></i> Imprimir
            </a>
            <a href="<?php echo site_url('garantias'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar
            </a>
        </div>
    </div>

    <div class="amura-form-card" style="padding: 24px;">
        <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head">
                        <table class="table">
                            <tbody>
                                <?php if ($emitente == null) { ?>
                                    <tr>
                                        <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/sistema/emitente">Configurar</a>
                                            <<<</td> </tr> <?php
                                } else { ?> <tr>
                                        <td style="width: 25%"><img src=" <?php echo $emitente->url_logo; ?> "></td>
                                        <td> <span style="font-size: 20px; ">
                                                <?php echo $emitente->nome; ?></span> </br><span>
                                                <?php echo $emitente->cnpj; ?> </br>
                                                <?php echo $emitente->rua . ', nº:' . $emitente->numero . ', ' . $emitente->bairro . ' - ' . $emitente->cidade . ' - ' . $emitente->uf; ?> </span> </br> <span> E-mail:
                                                <?php echo $emitente->email . ' - Fone: ' . $emitente->telefone; ?></span></td>
                                        <td style="width: 18%; text-align: center">#Garantia: <span>
                                                <?php echo $result->idGarantias ?></span></br> </br> <span>Emissão:
                                                <?php echo date('d/m/Y'); ?></span>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 40%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span>
                                                    <h5>Responsável</h5>
                                                </span>
                                                <span>
                                                    <?php echo $result->nome ?></span> <br />
                                                <span>Telefone:
                                                    <?php echo $result->telefone ?></span><br />
                                                <span>Email:
                                                    <?php echo $result->email ?></span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 30%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span>
                                                    <h5>Data</h5>
                                                </span>
                                                <span> <?php echo date('d/m/Y', strtotime($result->dataGarantia)); ?></span> <br />

                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 30%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span>
                                                    <h5>Ref. Termo</h5>
                                                </span>
                                                <span><?php echo $result->refGarantia ?> </span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 100%; padding-left: 0">
                                        <ul>
                                            <li>

                                                <span>
                                                    <h5>Texto da Garantia</h5>
                                                </span><br />
                                                <span><?php echo printSafeHtml($result->textoGarantia) ?></span><br />
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
