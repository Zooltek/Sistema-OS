<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Logs de Auditoria</h1>
                <p class="amura-header-subtitle">Registro cronológico de atividades, acessos e operações no sistema</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="#modal-excluir" role="button" data-toggle="modal" class="btn-amura-danger" title="Limpar histórico antigo">
                <i class='bx bx-trash'></i> Limpar Logs (> 30 dias)
            </a>
        </div>
    </div>

    <!-- Tabela -->
    <div class="amura-table-card">
        <div class="amura-table-wrapper">
            <table id="tabela" class="table">
                <thead>
                    <tr>
                        <th style="width: 160px;">Usuário</th>
                        <th style="width: 100px;">Data</th>
                        <th style="width: 90px;">Hora</th>
                        <th style="width: 130px;">IP de Acesso</th>
                        <th>Ação / Tarefa Executada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$results) { ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum registro de auditoria encontrado.</td>
                        </tr>
                    <?php } else {
                        foreach ($results as $r) {
                            echo '<tr>';
                            echo '<td><strong><i class="bx bx-user" style="color: #ff9204; margin-right: 4px;"></i> ' . html_escape($r->usuario) . '</strong></td>';
                            echo '<td>' . date('d/m/Y', strtotime($r->data)) . '</td>';
                            echo '<td>' . html_escape($r->hora) . '</td>';
                            echo '<td><code style="background: rgba(0,0,0,0.25); color: #93c5fd; padding: 2px 6px; border-radius: 4px;">' . html_escape($r->ip) . '</code></td>';
                            echo '<td>' . html_escape($r->tarefa) . '</td>';
                            echo '</tr>';
                        }
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

<!-- Modal Limpeza de Logs -->
<div id="modal-excluir" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo site_url('auditoria/clean') ?>" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Limpeza de Logs</h5>
        </div>
        <div class="modal-body">
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente remover os registros de log com mais de 30 dias?
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-danger">
                <i class='bx bx-trash'></i> Excluir Antigos
            </button>
        </div>
    </form>
</div>
