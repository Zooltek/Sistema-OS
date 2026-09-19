<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Clientes / Fornecedores</h1>
                <p class="amura-header-subtitle">Gerencie o cadastro unificado de clientes e fornecedores do sistema</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
                <a href="<?= base_url() ?>index.php/clientes/adicionar" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Adicionar Cliente / Fornecedor
                </a>
            <?php } ?>
        </div>
    </div>

    <!-- Filtros -->
    <div class="amura-filter-card">
        <form class="amura-filter-form" method="get" action="<?= base_url() ?>index.php/clientes">
            <div class="amura-filter-group" style="flex: 1 1 350px;">
                <label class="amura-filter-label">Pesquisar</label>
                <input type="text" name="pesquisa" id="pesquisa"
                    placeholder="Buscar por Nome, Documento, E-mail ou Telefone..." class="amura-input"
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
                        <th>Contato</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th style="width: 110px; text-align: center;">Tipo</th>
                        <th style="width: 140px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="9" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum cliente cadastrado</td></tr>';
                    }
                    foreach ($results as $r) {
                        echo '<tr>';
                        echo '<td><strong>#' . $r->idClientes . '</strong></td>';
                        echo '<td><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '">' . html_escape($r->nomeCliente) . '</a></td>';
                        echo '<td>' . html_escape($r->contato) . '</td>';
                        echo '<td>' . html_escape($r->documento) . '</td>';
                        echo '<td>' . html_escape($r->telefone) . '</td>';
                        echo '<td>' . html_escape($r->celular) . '</td>';
                        echo '<td>' . html_escape($r->email) . '</td>';

                        // Tipo
                        if ($r->fornecedor == 1) {
                            echo '<td style="text-align: center;"><span class="amura-badge amura-badge-purple">Fornecedor</span></td>';
                        } else {
                            echo '<td style="text-align: center;"><span class="amura-badge amura-badge-success">Cliente</span></td>';
                        }

                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
                            echo '<a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" class="amura-action-btn amura-action-view" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                            echo '<a href="' . base_url() . 'index.php/mine?e=' . $r->email . '" target="_blank" class="amura-action-btn amura-action-extra" title="Área do cliente"><i class="bx bx-key"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                            echo '<a href="' . base_url() . 'index.php/clientes/editar/' . $r->idClientes . '" class="amura-action-btn amura-action-edit" title="Editar Cliente"><i class="bx bx-edit"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" cliente="' . $r->idClientes . '" class="amura-action-btn amura-action-delete" title="Excluir Cliente"><i class="bx bx-trash-alt"></i></a>';
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
    <form action="<?php echo base_url() ?>index.php/clientes/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Cliente</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idCliente" name="id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente excluir este cliente e todos os dados associados a ele (OS, Vendas, Receitas)?
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
    $(document).ready(function () {
        $(document).on('click', 'a[cliente]', function (event) {
            var cliente = $(this).attr('cliente');
            $('#idCliente').val(cliente);
        });
    });
</script>
