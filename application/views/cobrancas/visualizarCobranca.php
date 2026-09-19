<div class="amura-page">
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Cobrança #<?php echo $result->idCobranca; ?></h1>
                <p class="amura-header-subtitle">Cliente: <strong><?php echo htmlspecialchars($result->nomeCliente); ?></strong> | Gateway: <strong><?php echo $result->payment_gateway; ?></strong></p>
            </div>
        </div>
        <div class="amura-header-actions" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <?php if ($result->payment_url) { ?>
                <a href="<?php echo $result->payment_url; ?>" target="_blank" class="btn-amura-primary">
                    <i class="bx bx-link-external"></i> Pagar
                </a>
            <?php } ?>
            <?php if ($result->pdf) { ?>
                <a href="<?php echo $result->pdf; ?>" target="_blank" class="btn-amura-secondary">
                    <i class="bx bx-file"></i> Abrir PDF
                </a>
            <?php } ?>
            <a href="<?php echo site_url('cobrancas'); ?>" class="btn-amura-secondary">
                <i class="bx bx-arrow-back"></i> Voltar
            </a>
        </div>
    </div>

    <div class="amura-form-card" style="padding: 24px;">
        <table class="table table-bordered amura-table">
            <tbody>
                <tr>
                    <td style="width: 25%"><strong>Cliente</strong></td>
                    <td><strong><?php echo $result->nomeCliente; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Documento</strong></td>
                    <td><?php echo $result->documento ?: '-'; ?></td>
                </tr>
                <tr>
                    <td><strong>Telefone / Celular</strong></td>
                    <td><?php echo $result->telefone . ($result->celular ? ' / ' . $result->celular : ''); ?></td>
                </tr>
                <tr>
                    <td><strong>E-mail</strong></td>
                    <td><?php echo $result->email ?: '-'; ?></td>
                </tr>
                <tr>
                    <td><strong>ID Interno</strong></td>
                    <td><code>#<?php echo $result->idCobranca; ?></code></td>
                </tr>
                <tr>
                    <td><strong>ID Externo (Charge ID)</strong></td>
                    <td><code><?php echo $result->charge_id ?: '-'; ?></code></td>
                </tr>
                <tr>
                    <td><strong>Gateway de Pagamento</strong></td>
                    <td><?php echo $result->payment_gateway; ?></td>
                </tr>
                <tr>
                    <td><strong>Valor da Cobrança</strong></td>
                    <td><strong style="color: #10b981; font-size: 1.15rem;">R$ <?php echo number_format($result->total / 100, 2, ',', '.'); ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Status Atual</strong></td>
                    <td>
                        <?php
                            echo getCobrancaTransactionStatus(
                                $this->config->item('payment_gateways'),
                                $result->payment_gateway,
                                $result->status
                            );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data de Expiração</strong></td>
                    <td><?php echo date('d/m/Y', strtotime($result->expire_at)); ?></td>
                </tr>
                <tr>
                    <td><strong>Método de Pagamento</strong></td>
                    <td><?php echo $result->payment_method; ?></td>
                </tr>
                <?php if ($result->payment_url) { ?>
                <tr>
                    <td><strong>URL de Pagamento</strong></td>
                    <td><a href="<?php echo $result->payment_url; ?>" target="_blank" style="color: #ff9204;"><?php echo $result->payment_url; ?></a></td>
                </tr>
                <?php } ?>
                <?php if ($result->barcode) { ?>
                <tr>
                    <td><strong>Código de Barras</strong></td>
                    <td><code><?php echo $result->barcode; ?></code></td>
                </tr>
                <?php } ?>
                <?php if ($result->message) { ?>
                <tr>
                    <td><strong>Mensagem</strong></td>
                    <td><?php echo $result->message; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
