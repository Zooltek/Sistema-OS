<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-lock"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Permissões</h1>
                <p class="amura-header-subtitle">Perfis de acesso e gerenciamento de permissões do sistema</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url(); ?>index.php/permissoes/adicionar" class="btn-amura-primary">
                <i class='bx bx-plus-circle'></i> Nova Permissão
            </a>
        </div>
    </div>

    <!-- Tabela -->
    <div class="amura-table-card">
        <div class="amura-table-wrapper">
            <table id="tabela" class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nome do Perfil</th>
                        <th style="width: 140px;">Criação</th>
                        <th style="width: 110px; text-align: center;">Situação</th>
                        <th style="width: 110px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="5" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhuma permissão cadastrada</td></tr>';
                    }
                    foreach ($results as $r) {
                        $situacaoTexto = ($r->situacao == 1) ? 'Ativo' : 'Inativo';
                        $situacaoBadge = ($r->situacao == 1) ? 'amura-badge-success' : 'amura-badge-danger';
                        echo '<tr>';
                        echo '<td><strong>#' . $r->idPermissao . '</strong></td>';
                        echo '<td><strong>' . html_escape($r->nome) . '</strong></td>';
                        echo '<td>' . date('d/m/Y', strtotime($r->data)) . '</td>';
                        echo '<td style="text-align: center;"><span class="amura-badge ' . $situacaoBadge . '">' . $situacaoTexto . '</span></td>';
                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';
                        echo '<a href="' . base_url() . 'index.php/permissoes/editar/' . $r->idPermissao . '" class="amura-action-btn amura-action-edit" title="Editar permissões"><i class="bx bx-edit"></i></a>';
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" permissao="' . $r->idPermissao . '" class="amura-action-btn amura-action-delete" title="Desativar Permissão"><i class="bx bx-notification-off"></i></a>';
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

<!-- Modal Desativar -->
<div id="modal-excluir" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/permissoes/desativar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-notification-off" style="color: #f87171; margin-right: 6px;"></i> Desativar Permissão</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idPermissao" name="id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente desativar esta permissão? Usuários associados a ela perderão os acessos.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-danger">
                <i class='bx bx-check'></i> Desativar
            </button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a[permissao]', function(event) {
            var permissao = $(this).attr('permissao');
            $('#idPermissao').val(permissao);
        });
    });
</script>
