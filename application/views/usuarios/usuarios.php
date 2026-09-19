<div class="amura-page">
    <!-- Header -->
    <div class="amura-header">
        <div class="amura-header-left">
            <div class="amura-header-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <h1 class="amura-header-title">Usuários</h1>
                <p class="amura-header-subtitle">Controle de operadores, administradores e níveis de acesso</p>
            </div>
        </div>
        <div class="amura-header-actions">
            <a href="<?= base_url('index.php/usuarios/adicionar') ?>" class="btn-amura-primary">
                <i class='bx bx-plus-circle'></i> Adicionar Usuário
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
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Nível de Acesso</th>
                        <th style="width: 100px; text-align: center;">Situação</th>
                        <th style="width: 110px;">Validade</th>
                        <th style="width: 80px; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($results)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 24px; color: #8c97a8;">Nenhum usuário cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($results as $r): ?>
                            <tr>
                                <td><strong>#<?= $r->idUsuarios ?></strong></td>
                                <td><strong><?= html_escape($r->nome) ?></strong></td>
                                <td><?= html_escape($r->cpf) ?></td>
                                <td><?= html_escape($r->telefone) ?></td>
                                <td><span class="amura-badge amura-badge-purple"><?= html_escape($r->permissao) ?></span></td>
                                <?php
                                $situacaoTexto = ($r->situacao == 1) ? 'Ativo' : 'Inativo';
                                $situacaoBadge = ($r->situacao == 1) ? 'amura-badge-success' : 'amura-badge-danger';
                                ?>
                                <td style="text-align: center;"><span class="amura-badge <?= $situacaoBadge ?>"><?= $situacaoTexto ?></span></td>
                                <td><?= $r->dataExpiracao ? date('d/m/Y', strtotime($r->dataExpiracao)) : '-' ?></td>
                                <td style="text-align: center;">
                                    <div class="amura-actions-cell" style="justify-content: center;">
                                        <a href="<?= base_url('index.php/usuarios/editar/' . $r->idUsuarios) ?>" class="amura-action-btn amura-action-edit" title="Editar Usuário"><i class="bx bx-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    <div class="amura-pagination">
        <?= $this->pagination->create_links(); ?>
    </div>
</div>
