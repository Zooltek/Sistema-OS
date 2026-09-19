<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-wrench"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Serviços</h1>
                <p class="amura-header-subtitle">Gerenciamento dos serviços prestados e catálogo de mão de obra</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aServico')) : ?>
                <a href="<?= base_url() ?>index.php/servicos/adicionar" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Adicionar Serviço
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filtros -->
    <div class="amura-filter-card">
        <form class="amura-filter-form" method="get" action="<?= base_url() ?>index.php/servicos">
            <div class="amura-filter-group" style="flex: 1 1 350px;">
                <label class="amura-filter-label">Pesquisar</label>
                <input type="text" name="pesquisa" id="pesquisa"
                    placeholder="Buscar por Nome ou Descrição do serviço..." class="amura-input"
                    value="<?= html_escape($this->input->get('pesquisa')) ?>">
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
                        <th style="width: 60px;">Cod.</th>
                        <th>Nome</th>
                        <th style="width: 140px; text-align: right;">Preço</th>
                        <th>Descrição</th>
                        <th style="width: 110px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="5" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum serviço cadastrado</td></tr>';
                    }
                    foreach ($results as $r) {
                        echo '<tr>';
                        echo '<td><strong>#' . $r->idServicos . '</strong></td>';
                        echo '<td><strong>' . html_escape($r->nome) . '</strong></td>';
                        echo '<td style="text-align: right;"><strong>R$ ' . number_format($r->preco, 2, ',', '.') . '</strong></td>';
                        echo '<td>' . html_escape($r->descricao) . '</td>';
                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')) {
                            echo '<a href="' . base_url() . 'index.php/servicos/editar/' . $r->idServicos . '" class="amura-action-btn amura-action-edit" title="Editar Serviço"><i class="bx bx-edit"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" servico="' . $r->idServicos . '" class="amura-action-btn amura-action-delete" title="Excluir Serviço"><i class="bx bx-trash-alt"></i></a>';
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
    <form action="<?php echo base_url() ?>index.php/servicos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Serviço</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idServico" name="id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">Deseja realmente excluir este serviço?</p>
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
        $(document).on('click', 'a[servico]', function(event) {
            var servico = $(this).attr('servico');
            $('#idServico').val(servico);
        });
    });
</script>
