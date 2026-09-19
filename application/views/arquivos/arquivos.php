<link rel="stylesheet" href="<?= base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-hdd"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Arquivos</h1>
                <p class="amura-header-subtitle">Gestão de documentos digitais, imagens e anexos do sistema</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aArquivo')) : ?>
                <a href="<?= base_url(); ?>index.php/arquivos/adicionar" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Novo Arquivo
                </a>
            <?php endif ?>
        </div>
    </div>

    <!-- Filtros -->
    <div class="amura-filter-card">
        <form class="amura-filter-form" method="get" action="<?= current_url(); ?>">
            <div class="amura-filter-group" style="flex: 2 1 300px;">
                <label class="amura-filter-label">Nome do Documento</label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Digite o nome do documento para pesquisar..." class="amura-input" value="<?= html_escape($this->input->get('pesquisa')) ?>">
            </div>
            <div class="amura-filter-group" style="flex: 1 1 150px;">
                <label class="amura-filter-label">Data Inicial</label>
                <input type="text" name="data" id="data" placeholder="dd/mm/aaaa" class="amura-input datepicker" autocomplete="off" value="<?= html_escape($this->input->get('data')) ?>">
            </div>
            <div class="amura-filter-group" style="flex: 1 1 150px;">
                <label class="amura-filter-label">Data Final</label>
                <input type="text" name="data2" id="data2" placeholder="dd/mm/aaaa" class="amura-input datepicker" autocomplete="off" value="<?= html_escape($this->input->get('data2')) ?>">
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
                        <th style="width: 50px;">#</th>
                        <th style="width: 70px; text-align: center;">Miniatura</th>
                        <th>Nome do Documento</th>
                        <th style="width: 95px;">Cadastro</th>
                        <th>Descrição</th>
                        <th style="width: 90px; text-align: right;">Tamanho</th>
                        <th style="width: 80px; text-align: center;">Tipo</th>
                        <th style="width: 130px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="8" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum arquivo encontrado</td></tr>';
                    }
                    foreach ($results as $r) : ?>
                        <tr>
                            <td><strong>#<?= $r->idDocumentos ?></strong></td>
                            <td style="text-align: center;">
                                <?php if (@getimagesize($r->path)) : ?>
                                    <a href="<?= $r->url ?>" target="_blank">
                                        <img src="<?= $r->url ?>" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; border: 1px solid #334255;">
                                    </a>
                                <?php else : ?>
                                    <span style="color: #64748b;"><i class='bx bx-file' style="font-size: 1.4rem;"></i></span>
                                <?php endif ?>
                            </td>
                            <td><strong><?= html_escape($r->documento) ?></strong></td>
                            <td><?= date('d/m/Y', strtotime($r->cadastro)) ?></td>
                            <td><?= html_escape($r->descricao) ?></td>
                            <td style="text-align: right;"><?= $r->tamanho ?> KB</td>
                            <td style="text-align: center;"><span class="amura-badge amura-badge-neutral"><?= strtoupper($r->tipo) ?></span></td>
                            <td style="text-align: center;">
                                <div class="amura-actions-cell" style="justify-content: center;">
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vArquivo')) : ?>
                                        <a href="<?= base_url() ?>index.php/arquivos/download/<?= $r->idDocumentos; ?>" class="amura-action-btn amura-action-view" title="Baixar Arquivo"><i class="bx bx-download"></i></a>
                                    <?php endif ?>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eArquivo')) : ?>
                                        <a href="<?= base_url() ?>index.php/arquivos/editar/<?= $r->idDocumentos ?>" class="amura-action-btn amura-action-edit" title="Editar"><i class="bx bx-edit"></i></a>
                                    <?php endif ?>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dArquivo')) : ?>
                                        <a href="#modal-excluir" role="button" data-toggle="modal" arquivo="<?= $r->idDocumentos ?>" class="amura-action-btn amura-action-delete" title="Excluir"><i class="bx bx-trash-alt"></i></a>
                                    <?php endif ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    <div class="amura-pagination">
        <?= $this->pagination->create_links() ?>
    </div>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?= base_url() ?>index.php/arquivos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Arquivo</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idDocumento" name="id" value="" />
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">
                Deseja realmente excluir este arquivo anexado?
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
        $(document).on('click', 'a[arquivo]', function(event) {
            var arquivo = $(this).attr('arquivo');
            $('#idDocumento').val(arquivo);
        });
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });
</script>