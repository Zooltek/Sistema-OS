<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Vendas</h1>
                <p class="amura-header-subtitle">Gestão de vendas de produtos, propostas comerciais e orçamentos</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) { ?>
                <a href="<?= base_url() ?>index.php/vendas/adicionar" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Nova Venda
                </a>
            <?php } ?>
        </div>
    </div>

    <!-- Filtros -->
    <div class="amura-filter-card">
        <form class="amura-filter-form" method="get" action="<?= base_url(); ?>index.php/vendas/gerenciar">
            <div class="amura-filter-group" style="flex: 2 1 240px;">
                <label class="amura-filter-label">Cliente</label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Nome do cliente..." class="amura-input" value="<?= html_escape($this->input->get('pesquisa')) ?>">
            </div>
            <div class="amura-filter-group" style="flex: 1 1 170px;">
                <label class="amura-filter-label">Status</label>
                <select name="status" class="amura-select">
                    <option value="">Todos os status</option>
                    <option value="Aberto" <?= $this->input->get('status') == 'Aberto' ? 'selected' : '' ?>>Aberto</option>
                    <option value="Faturado" <?= $this->input->get('status') == 'Faturado' ? 'selected' : '' ?>>Faturado</option>
                    <option value="Negociação" <?= $this->input->get('status') == 'Negociação' ? 'selected' : '' ?>>Negociação</option>
                    <option value="Em Andamento" <?= $this->input->get('status') == 'Em Andamento' ? 'selected' : '' ?>>Em Andamento</option>
                    <option value="Orçamento" <?= $this->input->get('status') == 'Orçamento' ? 'selected' : '' ?>>Orçamento</option>
                    <option value="Finalizado" <?= $this->input->get('status') == 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
                    <option value="Cancelado" <?= $this->input->get('status') == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    <option value="Aguardando Peças" <?= $this->input->get('status') == 'Aguardando Peças' ? 'selected' : '' ?>>Aguardando Peças</option>
                    <option value="Aprovado" <?= $this->input->get('status') == 'Aprovado' ? 'selected' : '' ?>>Aprovado</option>
                </select>
            </div>
            <div class="amura-filter-group" style="flex: 1 1 140px;">
                <label class="amura-filter-label">Data Inicial</label>
                <input type="date" name="data" id="data" class="amura-input" value="<?= html_escape($this->input->get('data')) ?>">
            </div>
            <div class="amura-filter-group" style="flex: 1 1 140px;">
                <label class="amura-filter-label">Data Final</label>
                <input type="date" name="data2" id="data2" class="amura-input" value="<?= html_escape($this->input->get('data2')) ?>">
            </div>
            <div class="amura-filter-group-btn">
                <button type="submit" class="amura-filter-search-btn">
                    <i class='bx bx-search-alt'></i><span>Pesquisar</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="amura-table-card">
        <div class="amura-table-wrapper">
            <table id="tabela" class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Nº</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th style="width: 95px;">Data Venda</th>
                        <th style="width: 110px; text-align: center;">Garantia</th>
                        <th style="text-align: right;">Total</th>
                        <th style="text-align: right;">Com Desc.</th>
                        <th style="width: 105px; text-align: center;">Status</th>
                        <th style="width: 75px; text-align: center;">Faturado</th>
                        <th style="width: 110px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="10" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhuma venda encontrada</td></tr>';
                    }
                    foreach ($results as $r) {
                        $dataVenda = date(('d/m/Y'), strtotime($r->dataVenda));
                        $vencGarantia = '';
                                        
                        if ($r->garantia && is_numeric($r->garantia)) {
                            $vencGarantia = dateInterval($r->dataVenda, $r->garantia);
                        }
                        $garantiaBadgeClass = 'amura-badge-neutral';
                        if (!empty($vencGarantia)) {
                            $dataGarantia = explode('/', $vencGarantia);
                            $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
                            $garantiaBadgeClass = (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) ? 'amura-badge-success' : 'amura-badge-danger';
                        } elseif ($r->garantia == "0") {
                            $vencGarantia = 'Sem Garantia';
                        }

                        $faturadoBadge = ($r->faturado == 1) ? '<span class="amura-badge amura-badge-success">Sim</span>' : '<span class="amura-badge amura-badge-neutral">Não</span>';

                        $statusBadgeClass = match($r->status) {
                            'Aberto' => 'amura-badge-info',
                            'Em Andamento' => 'amura-badge-purple',
                            'Orçamento' => 'amura-badge-neutral',
                            'Negociação' => 'amura-badge-warning',
                            'Cancelado' => 'amura-badge-danger',
                            'Finalizado' => 'amura-badge-success',
                            'Faturado' => 'amura-badge-purple',
                            'Aguardando Peças' => 'amura-badge-warning',
                            'Aprovado' => 'amura-badge-success',
                            default => 'amura-badge-neutral',
                        };

                        if ($r->faturado == 1) {
                            $valorTotal = 'R$ ' . number_format($r->valorTotal, 2, ',', '.');
                            $valorDesconto = 'R$ ' . number_format($r->desconto, 2, ',', '.');
                            $valorFinal = 'R$ ' . number_format($r->valor_desconto, 2, ',', '.');
                        } else {
                            $valorProdutos = isset($r->totalProdutos) ? $r->totalProdutos : 0.00;
                            $desconto = isset($r->desconto) ? $r->desconto : 0.00;
                            $valorComDesconto = $valorProdutos - $desconto;
                            $valorTotal = 'R$ ' . number_format($valorProdutos, 2, ',', '.');
                            $valorDesconto = 'R$ ' . number_format($desconto, 2, ',', '.');
                            $valorFinal = 'R$ ' . number_format($valorComDesconto, 2, ',', '.');
                        }

                        echo '<tr>';
                        echo '<td><strong>#' . $r->idVendas . '</strong></td>';
                        echo '<td><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '">' . html_escape($r->nomeCliente) . '</a></td>';
                        echo '<td>' . html_escape($r->nome) . '</td>';
                        echo '<td>' . $dataVenda . '</td>';
                        echo '<td style="text-align: center;"><span class="amura-badge ' . $garantiaBadgeClass . '">' . ($vencGarantia ?: '-') . '</span></td>';
                        echo '<td style="text-align: right;">' . $valorTotal . '</td>';
                        echo '<td style="text-align: right;"><strong>' . $valorFinal . '</strong></td>';
                        echo '<td style="text-align: center;"><span class="amura-badge ' . $statusBadgeClass . '">' . html_escape($r->status) . '</span></td>';
                        echo '<td style="text-align: center;">' . $faturadoBadge . '</td>';
                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';

                        // Visualizar diretamente visível
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
                            echo '<a href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" class="amura-action-btn amura-action-view" title="Ver detalhes"><i class="bx bx-show"></i></a>';
                        }

                        $editavel = $this->vendas_model->isEditable($r->idVendas);

                        // Editar diretamente visível
                        if (($r->faturado != 1 || $editavel) && $this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
                            echo '<a href="' . base_url() . 'index.php/vendas/editar/' . $r->idVendas . '" class="amura-action-btn amura-action-edit" title="Editar venda"><i class="bx bx-edit"></i></a>';
                        }

                        // Demais ações agrupadas em dropdown
                        $temImpressao = $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda');
                        $temExclusao = ($r->faturado != 1 || $editavel) && $this->permission->checkPermission($this->session->userdata('permissao'), 'dVenda');

                        if ($temImpressao || $temExclusao) {
                            echo '<div class="amura-action-dropdown dropdown">';
                            echo '<a href="#" class="amura-action-btn dropdown-toggle" data-toggle="dropdown" title="Mais Ações" style="background: rgba(148,163,184,0.08); color: #94a3b8; border-color: rgba(148,163,184,0.15);">';
                            echo '<i class="bx bx-dots-vertical-rounded"></i>';
                            echo '</a>';
                            echo '<ul class="dropdown-menu amura-action-dropdown-menu">';
                            if ($temImpressao) {
                                echo '<li>';
                                echo '<a href="' . base_url() . 'index.php/vendas/imprimir/' . $r->idVendas . '" target="_blank">';
                                echo '<i class="bx bx-printer" style="color: #fbbf24;"></i>';
                                echo '<span>Imprimir A4</span>';
                                echo '</a>';
                                echo '</li>';
                                echo '<li>';
                                echo '<a href="' . base_url() . 'index.php/vendas/imprimirTermica/' . $r->idVendas . '" target="_blank">';
                                echo '<i class="bx bx-receipt" style="color: #38bdf8;"></i>';
                                echo '<span>Imprimir Cupom Térmico</span>';
                                echo '</a>';
                                echo '</li>';
                            }
                            if ($temExclusao) {
                                if ($temImpressao) {
                                    echo '<li class="divider"></li>';
                                }
                                echo '<li>';
                                echo '<a href="#modal-excluir" role="button" data-toggle="modal" venda="' . $r->idVendas . '" style="color: #f87171 !important;">';
                                echo '<i class="bx bx-trash-alt" style="color: #ef4444;"></i>';
                                echo '<span>Excluir Venda</span>';
                                echo '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
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
<div id="modal-excluir" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/vendas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Venda</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVenda" name="id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">Deseja realmente excluir esta venda?</p>
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

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a[venda]', function(event) {
            var venda = $(this).attr('venda');
            $('#idVenda').val(venda);
        });
    });
</script>
