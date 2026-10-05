<div class="amura-page">
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-box"></i>
            </div>
            <div>
                <h1 class="amura-header-title"><?php echo htmlspecialchars($result->descricao); ?></h1>
                <p class="amura-header-subtitle">
                    Cód. Barras: <strong><?php echo $result->codDeBarra ?: 'N/A'; ?></strong> 
                    <?php if (!empty($result->categoria)) { ?> | Categoria: <strong><?php echo htmlspecialchars($result->categoria); ?></strong><?php } ?>
                    <?php if (!empty($result->marca)) { ?> | Marca: <strong><?php echo htmlspecialchars($result->marca); ?></strong><?php } ?>
                    | Estoque: <strong><?php echo $result->estoque; ?> <?php echo $result->unidade; ?></strong>
                </p>
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

    <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 20px;">
        <!-- Card 1: Ficha Técnica & Identificação -->
        <div class="amura-form-card" style="padding: 24px;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #ff9204; margin-top: 0; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="bx bx-list-check"></i> Ficha Cadastral do Produto
            </h3>

            <table class="table table-bordered amura-table" style="margin-bottom: 0;">
                <tbody>
                    <tr>
                        <td style="width: 30%"><strong>Código de Barras</strong></td>
                        <td><code><?php echo $result->codDeBarra ?: 'Sem código'; ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Descrição / Nome</strong></td>
                        <td><strong style="color: #ff9204;"><?php echo htmlspecialchars($result->descricao); ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong>Categoria</strong></td>
                        <td><?php echo !empty($result->categoria) ? htmlspecialchars($result->categoria) : '<span style="color:#64748b;">Não informada</span>'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Marca / Fabricante</strong></td>
                        <td><?php echo !empty($result->marca) ? htmlspecialchars($result->marca) : '<span style="color:#64748b;">Não informada</span>'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Modelo</strong></td>
                        <td><?php echo !empty($result->modelo) ? htmlspecialchars($result->modelo) : '<span style="color:#64748b;">Não informado</span>'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Cód. Identificação (IMEI / Série)</strong></td>
                        <td><?php echo !empty($result->codigo_identificacao) ? '<code>' . htmlspecialchars($result->codigo_identificacao) . '</code>' : '<span style="color:#64748b;">Não informado</span>'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Unidade de Medida</strong></td>
                        <td><span class="badge" style="background:#334155; color:#f1f5f9; padding:3px 8px;"><?php echo $result->unidade; ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Prazo de Garantia</strong></td>
                        <td><?php echo !empty($result->garantia) ? htmlspecialchars($result->garantia) : '<span style="color:#64748b;">Sem garantia especificada</span>'; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Permissões de Movimentação</strong></td>
                        <td>
                            <span class="badge" style="background: <?php echo $result->entrada ? '#059669' : '#475569'; ?>; color:#fff; margin-right:4px;">
                                <?php echo $result->entrada ? 'Entrada Habilitada' : 'Sem Entrada'; ?>
                            </span>
                            <span class="badge" style="background: <?php echo $result->saida ? '#2563eb' : '#475569'; ?>; color:#fff;">
                                <?php echo $result->saida ? 'Saída Habilitada' : 'Sem Saída'; ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Card 2: Estoque, Precificação & Rentabilidade -->
        <div>
            <!-- Box de Estoque e Localização -->
            <div class="amura-form-card" style="padding: 24px; margin-bottom: 20px;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #ff9204; margin-top: 0; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="bx bx-cube"></i> Estoque & Armazenagem
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div style="background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.06); border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">Estoque Atual</div>
                        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 4px; color: <?php echo ($result->estoque <= $result->estoqueMinimo) ? '#ef4444' : '#10b981'; ?>;">
                            <?php echo $result->estoque; ?> <small style="font-size: 0.85rem; font-weight: 500; color: #94a3b8;"><?php echo $result->unidade; ?></small>
                        </div>
                    </div>
                    <div style="background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.06); border-radius: 8px; padding: 12px; text-align: center;">
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">Estoque Mínimo</div>
                        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 4px; color: #f59e0b;">
                            <?php echo $result->estoqueMinimo ?: '0'; ?> <small style="font-size: 0.85rem; font-weight: 500; color: #94a3b8;"><?php echo $result->unidade; ?></small>
                        </div>
                    </div>
                </div>

                <div style="background: rgba(30,41,59,0.3); border: 1px solid rgba(255,255,255,0.06); border-radius: 6px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 0.85rem; color: #cbd5e1;"><i class="bx bx-map-pin" style="color:#ff9204;"></i> Localização Física:</span>
                    <strong style="color: #f8fafc; font-size: 0.9rem;"><?php echo !empty($result->localizacao) ? htmlspecialchars($result->localizacao) : 'Não definida'; ?></strong>
                </div>
            </div>

            <!-- Box de Rentabilidade e Preços -->
            <?php 
                $precoCompra = floatval($result->precoCompra);
                $precoVenda = floatval($result->precoVenda);
                $lucroBruto = $precoVenda - $precoCompra;
                $margem = $precoVenda > 0 ? (($lucroBruto / $precoVenda) * 100) : 0;
                $markup = $precoCompra > 0 ? (($lucroBruto / $precoCompra) * 100) : 0;
            ?>
            <div class="amura-form-card" style="padding: 24px;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #ff9204; margin-top: 0; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                    <i class="bx bx-dollar-circle"></i> Valores & Rentabilidade
                </h3>

                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <span style="color: #94a3b8;">Preço de Compra (Custo):</span>
                    <strong style="color: #e2e8f0;">R$ <?php echo number_format($precoCompra, 2, ',', '.'); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <span style="color: #94a3b8;">Preço de Venda (Final):</span>
                    <strong style="color: #10b981; font-size: 1.15rem;">R$ <?php echo number_format($precoVenda, 2, ',', '.'); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06);">
                    <span style="color: #94a3b8;">Lucro Bruto Unitário:</span>
                    <strong style="color: <?php echo $lucroBruto >= 0 ? '#4ade80' : '#f87171'; ?>;">R$ <?php echo number_format($lucroBruto, 2, ',', '.'); ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <span style="color: #94a3b8;">Margem / Markup Real:</span>
                    <span style="color: #38bdf8; font-weight: 700;">
                        <?php echo number_format($margem, 1, ',', '.'); ?>% <span style="font-size:0.8rem; font-weight:400; color:#94a3b8;">margem</span> / <?php echo number_format($markup, 1, ',', '.'); ?>% <span style="font-size:0.8rem; font-weight:400; color:#94a3b8;">markup</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($result->observacoes)) { ?>
        <!-- Observações e Especificações -->
        <div class="amura-form-card" style="padding: 24px; margin-top: 20px;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #ff9204; margin-top: 0; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <i class="bx bx-notepad"></i> Especificações & Observações Técnicas
            </h3>
            <div style="color: #cbd5e1; font-size: 0.9rem; line-height: 1.6; white-space: pre-wrap; background: rgba(15,23,42,0.4); border: 1px solid rgba(255,255,255,0.06); border-radius: 6px; padding: 14px 18px;">
                <?php echo nl2br(htmlspecialchars($result->observacoes)); ?>
            </div>
        </div>
    <?php } ?>
</div>
