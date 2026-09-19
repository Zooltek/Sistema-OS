<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Cobranças</h1>
                <p class="amura-header-subtitle">Controle financeiro de transações, boletos e gateways de pagamento</p>
            </div>
        </div>
    </div>

    <!-- Tabela -->
    <div class="amura-table-card">
        <div class="amura-table-wrapper">
            <table id="tabela" class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Gateway</th>
                        <th>Tipo</th>
                        <th style="width: 110px;">Vencimento</th>
                        <th>Referência</th>
                        <th style="width: 120px; text-align: center;">Status</th>
                        <th style="width: 120px; text-align: right;">Valor</th>
                        <th style="width: 170px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="8" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhuma cobrança cadastrada</td></tr>';
                    }
                    foreach ($results as $r) {
                        $dataVenda = date(('d/m/Y'), strtotime($r->expire_at));
                        $cobrancaStatus = getCobrancaTransactionStatus(
                            $this->config->item('payment_gateways'),
                            $r->payment_gateway,
                            $r->status
                        );

                        echo '<tr>';
                        echo '<td><strong>#' . $r->idCobranca . '</strong></td>';
                        echo '<td><span class="amura-badge amura-badge-neutral">' . html_escape($r->payment_gateway) . '</span></td>';
                        echo '<td>' . html_escape($r->payment_method) . '</td>';
                        echo '<td>' . $dataVenda . '</td>';

                        echo '<td>';
                        if ($r->os_id != '') {
                            echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->os_id . '"><i class="bx bx-wrench"></i> OS: #' . $r->os_id . '</a>';
                        }
                        if ($r->vendas_id != '') {
                            echo '<a href="' . base_url() . 'index.php/vendas/visualizar/' . $r->vendas_id . '"><i class="bx bx-cart"></i> Venda: #' . $r->vendas_id . '</a>';
                        }
                        echo '</td>';

                        echo '<td style="text-align: center;"><span class="amura-badge amura-badge-info">' . $cobrancaStatus . '</span></td>';
                        echo '<td style="text-align: right;"><strong>R$ ' . number_format($r->total / 100, 2, ',', '.') . '</strong></td>';
                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';

                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCobranca')) {
                            echo '<a href="#modal-cancelar" role="button" data-toggle="modal" cancela_id="' . $r->idCobranca . '" class="amura-action-btn amura-action-delete" title="Cancelar Cobrança"><i class="bx bx-x"></i></a>';
                            echo '<a href="' . base_url() . 'index.php/cobrancas/atualizar/' . $r->idCobranca . '" class="amura-action-btn amura-action-view" title="Atualizar Cobrança"><i class="bx bx-refresh"></i></a>';
                            echo '<a href="#modal-confirmar" role="button" data-toggle="modal" confirma_id="' . $r->idCobranca . '" class="amura-action-btn amura-action-extra" title="Confirmar pagamento"><i class="bx bx-check"></i></a>';
                            echo '<a href="' . base_url() . 'index.php/cobrancas/visualizar/' . $r->idCobranca . '" class="amura-action-btn amura-action-view" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                            echo '<a href="' . base_url() . 'index.php/cobrancas/enviarEmail/' . $r->idCobranca . '" class="amura-action-btn amura-action-edit" title="Enviar por E-mail"><i class="bx bx-envelope"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCobranca') && $r->barcode != '') {
                            echo '<a href="' . $r->link . '" target="_blank" class="amura-action-btn amura-action-print" title="Visualizar boleto"><i class="bx bx-barcode"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCobranca')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" excluir_id="' . $r->idCobranca . '" class="amura-action-btn amura-action-delete" title="Excluir Cobrança"><i class="bx bx-trash-alt"></i></a>';
                        }
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    <div class="amura-pagination">
        <?= $this->pagination->create_links(); ?>
    </div>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelExcluir" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cobrancas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabelExcluir"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Cobrança</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="excluir_id" name="excluir_id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente excluir esta cobrança? Ela será cancelada definitivamente.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-danger">
                <i class='bx bx-trash'></i> Excluir
            </button>
        </div>
    </form>
</div>

<!-- Modal Confirmar Pagamento -->
<div id="modal-confirmar" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelConfirmar" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cobrancas/confirmarpagamento" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabelConfirmar"><i class="bx bx-check-circle" style="color: #4ade80; margin-right: 6px;"></i> Confirmar Pagamento</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="confirma_id" name="confirma_id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente confirmar o pagamento desta cobrança manualmente?
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-primary">
                <i class="bx bx-check"></i> Confirmar
            </button>
        </div>
    </form>
</div>

<!-- Modal Cancelar Cobrança -->
<div id="modal-cancelar" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCancelar" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/cobrancas/cancelar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabelCancelar"><i class="bx bx-x-circle" style="color: #f87171; margin-right: 6px;"></i> Cancelar Cobrança</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="cancela_id" name="cancela_id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente cancelar esta cobrança no gateway?
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Voltar
            </button>
            <button type="submit" class="btn-amura-danger">
                <i class="bx bx-x"></i> Cancelar Cobrança
            </button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a[excluir_id]', function(event) {
            var cobranca = $(this).attr('excluir_id');
            $('#excluir_id').val(cobranca);
        });

        $(document).on('click', 'a[confirma_id]', function(event) {
            var cobranca = $(this).attr('confirma_id');
            $('#confirma_id').val(cobranca);
        });

        $(document).on('click', 'a[cancela_id]', function(event) {
            var cobranca = $(this).attr('cancela_id');
            $('#cancela_id').val(cobranca);
        });
    });
</script>