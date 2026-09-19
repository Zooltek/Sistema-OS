<div class="amura-page">
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <h1 class="amura-header-title"><?php echo htmlspecialchars($result->descricao); ?></h1>
                <p class="amura-header-subtitle">Cód. Barras: <strong><?php echo $result->codDeBarra ?: 'N/A'; ?></strong> | Unidade: <?php echo $result->unidade; ?> | Estoque: <strong><?php echo $result->estoque; ?></strong></p>
            </div>
        </div>
        <div class="amura-header-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) { ?>
                <a class="btn-amura-primary" href="<?php echo base_url(); ?>index.php/produtos/editar/<?php echo $result->idProdutos; ?>">
                    <i class="bx bx-edit"></i> Editar Produto
                </a>
            <?php } ?>
            <a class="btn-amura-secondary" href="<?php echo site_url('produtos'); ?>">
                <i class="bx bx-arrow-back"></i> Voltar
            </a>
        </div>
    </div>

    <div class="amura-form-card" style="padding: 24px;">
        <table class="table table-bordered amura-table">
            <tbody>
                <tr>
                    <td style="width: 25%"><strong>Código de Barra</strong></td>
                    <td><?php echo $result->codDeBarra ?: '-'; ?></td>
                </tr>
                <tr>
                    <td><strong>Descrição</strong></td>
                    <td><strong style="color: #ff9204;"><?php echo $result->descricao; ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Unidade de Medida</strong></td>
                    <td><?php echo $result->unidade; ?></td>
                </tr>
                <tr>
                    <td><strong>Preço de Compra</strong></td>
                    <td>R$ <?php echo number_format($result->precoCompra, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><strong>Preço de Venda</strong></td>
                    <td><strong style="color: #10b981; font-size: 1.1rem;">R$ <?php echo number_format($result->precoVenda, 2, ',', '.'); ?></strong></td>
                </tr>
                <tr>
                    <td><strong>Estoque Atual</strong></td>
                    <td>
                        <span class="amura-badge <?php echo $result->estoque <= $result->estoqueMinimo ? 'status-danger' : 'status-success'; ?>">
                            <?php echo $result->estoque; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Estoque Mínimo</strong></td>
                    <td><?php echo $result->estoqueMinimo; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
