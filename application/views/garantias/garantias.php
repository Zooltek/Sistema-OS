<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Termos de Garantia</h1>
                <p class="amura-header-subtitle">Modelos de termos e condições de garantia para ordens de serviço e vendas</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aGarantia')) { ?>
                <a href="<?= base_url(); ?>index.php/garantias/adicionar" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Novo Termo de Garantia
                </a>
            <?php } ?>
        </div>
    </div>

    <!-- Tabela -->
    <div class="amura-table-card">
        <div class="amura-table-wrapper">
            <table id="tabela" class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 100px;">Data</th>
                        <th style="width: 200px;">Ref. Garantia</th>
                        <th>Resumo do Termo</th>
                        <th style="width: 150px;">Usuário</th>
                        <th style="width: 140px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="6" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum termo de garantia cadastrado</td></tr>';
                    }
                    foreach ($results as $r) {
                        $dataGarantia = date(('d/m/Y'), strtotime($r->dataGarantia));
                        $textoGarantiaShort = mb_strimwidth(strip_tags($r->textoGarantia), 0, 80, "...");

                        echo '<tr>';
                        echo '<td><strong>#' . $r->idGarantias . '</strong></td>';
                        echo '<td>' . $dataGarantia . '</td>';
                        echo '<td><strong>' . html_escape($r->refGarantia) . '</strong></td>';
                        echo '<td style="color: #94a3b8;">' . html_escape($textoGarantiaShort) . '</td>';
                        echo '<td><a href="' . base_url() . 'index.php/usuarios/editar/' . $r->idUsuarios . '"><i class="bx bx-user"></i> ' . html_escape($r->nome) . '</a></td>';
                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vGarantia')) {
                            echo '<a href="' . base_url() . 'index.php/garantias/visualizar/' . $r->idGarantias . '" class="amura-action-btn amura-action-view" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                            echo '<a href="' . base_url() . 'index.php/garantias/imprimir/' . $r->idGarantias . '" target="_blank" class="amura-action-btn amura-action-print" title="Imprimir"><i class="bx bx-printer"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eGarantia')) {
                            echo '<a href="' . base_url() . 'index.php/garantias/editar/' . $r->idGarantias . '" class="amura-action-btn amura-action-edit" title="Editar"><i class="bx bx-edit"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dGarantia')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" garantia="' . $r->idGarantias . '" class="amura-action-btn amura-action-delete" title="Excluir"><i class="bx bx-trash-alt"></i></a>';
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
    <form action="<?php echo base_url() ?>index.php/garantias/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Termo de Garantia</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idGarantias" name="idGarantias" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente excluir este termo de garantia?
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

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a[garantia]', function(event) {
            var garantia = $(this).attr('garantia');
            $('#idGarantias').val(garantia);
        });
    });
</script>
