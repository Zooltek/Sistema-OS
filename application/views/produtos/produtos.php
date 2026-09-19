<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Produtos</h1>
                <p class="amura-header-subtitle">Gerenciamento de estoque e catálogo de produtos cadastrados</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aProduto')) : ?>
                <a href="<?= base_url() ?>index.php/produtos/adicionar" class="btn-amura-primary">
                    <i class='bx bx-plus-circle'></i> Adicionar Produto
                </a>
                <a href="#modal-etiquetas" role="button" data-toggle="modal" class="btn-amura-secondary">
                    <i class='bx bx-barcode-reader'></i> Gerar Etiquetas
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filtros -->
    <div class="amura-filter-card">
        <form class="amura-filter-form" method="get" action="<?= base_url() ?>index.php/produtos">
            <div class="amura-filter-group" style="flex: 1 1 350px;">
                <label class="amura-filter-label">Pesquisar</label>
                <input type="text" name="pesquisa" id="pesquisa"
                    placeholder="Buscar por Nome ou Código de Barras..." class="amura-input"
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
                        <th style="width: 140px;">Cod. Barra</th>
                        <th>Nome / Descrição</th>
                        <th style="width: 100px; text-align: center;">Estoque</th>
                        <th style="width: 120px; text-align: right;">Preço Venda</th>
                        <th style="width: 160px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="6" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum produto cadastrado</td></tr>';
                    }
                    foreach ($results as $r) {
                        $estoqueBadge = ($r->estoque <= 0) ? 'amura-badge-danger' : (($r->estoque <= 5) ? 'amura-badge-warning' : 'amura-badge-neutral');
                        echo '<tr>';
                        echo '<td><strong>#' . $r->idProdutos . '</strong></td>';
                        echo '<td>' . html_escape($r->codDeBarra) . '</td>';
                        echo '<td>' . html_escape($r->descricao) . '</td>';
                        echo '<td style="text-align: center;"><span class="amura-badge ' . $estoqueBadge . '">' . $r->estoque . '</span></td>';
                        echo '<td style="text-align: right;"><strong>R$ ' . number_format($r->precoVenda, 2, ',', '.') . '</strong></td>';
                        echo '<td style="text-align: center;">';
                        echo '<div class="amura-actions-cell" style="justify-content: center;">';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
                            echo '<a href="' . base_url() . 'index.php/produtos/visualizar/' . $r->idProdutos . '" class="amura-action-btn amura-action-view" title="Visualizar Produto"><i class="bx bx-show"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) {
                            echo '<a href="' . base_url() . 'index.php/produtos/editar/' . $r->idProdutos . '" class="amura-action-btn amura-action-edit" title="Editar Produto"><i class="bx bx-edit"></i></a>';
                            echo '<a href="#atualizar-estoque" role="button" data-toggle="modal" produto="' . $r->idProdutos . '" estoque="' . $r->estoque . '" class="amura-action-btn amura-action-extra" title="Atualizar Estoque"><i class="bx bx-plus-circle"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" produto="' . $r->idProdutos . '" class="amura-action-btn amura-action-delete" title="Excluir Produto"><i class="bx bx-trash-alt"></i></a>';
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
    <form action="<?php echo base_url() ?>index.php/produtos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="bx bx-trash" style="color: #f87171; margin-right: 6px;"></i> Excluir Produto</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idProduto" class="idProduto" name="id" value=""/>
            <p style="text-align: center; margin: 10px 0; font-size: 0.95rem;">Deseja realmente excluir este produto?</p>
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

<!-- Modal Atualizar Estoque -->
<div id="atualizar-estoque" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="modalEstoqueLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/produtos/atualizar_estoque" method="post" id="formEstoque">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="modalEstoqueLabel"><i class="bx bx-plus-circle" style="color: #ff9204; margin-right: 6px;"></i> Atualizar Estoque</h5>
        </div>
        <div class="modal-body">
            <div class="amura-form-group" style="margin-bottom: 14px;">
                <label for="estoqueAtual" class="amura-form-label">Estoque Atual</label>
                <input id="estoqueAtual" type="text" name="estoqueAtual" value="" readonly class="amura-input" style="opacity: 0.75;" />
            </div>
            <div class="amura-form-group">
                <label for="estoque" class="amura-form-label">Adicionar ao Estoque <span style="color: #f87171;">*</span></label>
                <input type="hidden" id="idProdutoModal" class="idProduto" name="id" value=""/>
                <input id="estoque" type="text" name="estoque" value="" class="amura-input" placeholder="Informe a quantidade a adicionar" />
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-primary">
                <i class="bx bx-sync"></i> Atualizar Estoque
            </button>
        </div>
    </form>
</div>

<!-- Modal Etiquetas -->
<div id="modal-etiquetas" class="modal hide fade amura-modal" tabindex="-1" role="dialog" aria-labelledby="modalEtiquetasLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/relatorios/produtosEtiquetas" method="get">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="modalEtiquetasLabel"><i class="bx bx-barcode-reader" style="color: #ff9204; margin-right: 6px;"></i> Gerar Etiquetas de Código de Barras</h5>
        </div>
        <div class="modal-body">
            <div style="background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.25); color: #93c5fd; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 0.84rem;">
                <i class="bx bx-info-circle"></i> Escolha o intervalo de produtos para gerar as etiquetas.
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                <div class="amura-form-group">
                    <label for="de_id" class="amura-form-label">Do ID</label>
                    <input class="amura-input" type="text" id="de_id" name="de_id" placeholder="ID do primeiro produto" value=""/>
                </div>
                <div class="amura-form-group">
                    <label for="ate_id" class="amura-form-label">Até o ID</label>
                    <input class="amura-input" type="text" id="ate_id" name="ate_id" placeholder="ID do último produto" value=""/>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="amura-form-group">
                    <label class="amura-form-label">Formato da Etiqueta</label>
                    <select class="amura-select" name="etiquetaCode">
                        <option value="EAN13">EAN-13</option>
                        <option value="UPCA">UPCA</option>
                        <option value="C93">CODE 93</option>
                        <option value="C128A">CODE 128</option>
                        <option value="CODABAR">CODABAR</option>
                        <option value="QR">QR-CODE</option>
                    </select>
                </div>
                <div class="amura-form-group" style="justify-content: center; padding-top: 18px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #cbd5e1; font-size: 0.85rem;">
                        <input type="checkbox" name="qtdEtiqueta" value="true" style="margin: 0; width: 16px; height: 16px;"/>
                        Imprimir com Qtd. do Estoque
                    </label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-amura-secondary" data-dismiss="modal" aria-hidden="true">
                <i class="bx bx-x"></i> Cancelar
            </button>
            <button type="submit" class="btn-amura-primary">
                <i class='bx bx-barcode'></i> Gerar Etiquetas
            </button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', 'a[produto]', function (event) {
            var produto = $(this).attr('produto');
            var estoque = $(this).attr('estoque');
            $('.idProduto').val(produto);
            $('#estoqueAtual').val(estoque);
        });

        $('#formEstoque').validate({
            rules: {
                estoque: {
                    required: true,
                    number: true
                }
            },
            messages: {
                estoque: {
                    required: 'Campo Requerido.',
                    number: 'Informe um número válido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function (element, errorClass, validClass) {
                $(element).parents('.amura-form-group').addClass('error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents('.amura-form-group').removeClass('error');
            }
        });
    });
</script>
