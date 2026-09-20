<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table-custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>

<style>
/* ==========================================================================
   Amura Sistemas - Design Corporativo ERP: Ordens de Serviço
   ========================================================================== */

/* Layout Principal da Página */
.os-page-wrapper {
  margin-top: 12px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  color: #d8dde6;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* 1. Header Corporativo com Título e Ação Principal */
.os-header-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 14px;
  background: #141b22;
  border: 1px solid #252e3b;
  border-radius: 8px;
  padding: 14px 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
}

.os-title-area {
  display: flex;
  align-items: center;
  gap: 12px;
}

.os-title-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  background: rgba(222, 121, 2, 0.12);
  border: 1px solid rgba(222, 121, 2, 0.28);
  border-radius: 8px;
  color: #ff9204;
  font-size: 20px;
}

.os-title-text h2 {
  margin: 0;
  font-size: 1.28rem;
  font-weight: 700;
  color: #f1f4f9;
  letter-spacing: -0.2px;
  line-height: 1.2;
}

.os-title-text p {
  margin: 3px 0 0 0;
  font-size: 0.82rem;
  color: #8c97a8;
}

/* Botão de Ação Primária Amura */
.btn-amura-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(180deg, #ff9b1a 0%, #e07a00 100%);
  color: #ffffff !important;
  border: 1px solid #d06d00;
  border-radius: 6px;
  padding: 8px 18px;
  font-size: 0.88rem;
  font-weight: 600;
  text-decoration: none !important;
  box-shadow: 0 2px 6px rgba(224, 122, 0, 0.35);
  transition: all 0.2s ease-in-out;
  cursor: pointer;
}

.btn-amura-primary:hover {
  background: linear-gradient(180deg, #ffa834 0%, #eb8405 100%);
  border-color: #e57f00;
  box-shadow: 0 4px 12px rgba(224, 122, 0, 0.5);
  transform: translateY(-1px);
  color: #ffffff !important;
}

.btn-amura-primary:active {
  transform: translateY(0);
  box-shadow: 0 1px 3px rgba(224, 122, 0, 0.4);
}

.btn-amura-primary i {
  font-size: 1.15rem;
}

/* 2. Barra de Filtros Corporativa */
.os-filter-card {
  background: #161e27;
  border: 1px solid #232d3b;
  border-radius: 8px;
  padding: 14px 18px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
}

.os-filter-form {
  display: grid;
  grid-template-columns: minmax(200px, 2fr) minmax(150px, 1.2fr) minmax(220px, 1.4fr) auto;
  gap: 12px;
  align-items: end;
  margin: 0;
}

.os-filter-group {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

/* Célula do botão Pesquisar: alinha ao fim do eixo vertical sem label fantasma */
.os-filter-btn-wrap {
  display: flex;
  align-items: flex-end;
}


.os-filter-label {
  font-size: 0.76rem !important;
  font-weight: 600 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.4px !important;
  color: #8c97a8 !important;
  margin: 0 !important;
  line-height: 1.2 !important;
}

.os-input,
.os-select {
  width: 100% !important;
  height: 36px !important;
  min-height: 36px !important;
  max-height: 36px !important;
  line-height: 22px !important;
  padding: 6px 12px !important;
  margin: 0 !important;
  margin-bottom: 0 !important;
  font-size: 0.85rem !important;
  background: #0d1218 !important;
  border: 1px solid #283344 !important;
  border-radius: 5px !important;
  color: #e2e8f0 !important;
  outline: none !important;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.4) !important;
  box-sizing: border-box !important;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.os-input:focus,
.os-select:focus {
  border-color: #ff9204 !important;
  box-shadow: 0 0 0 2px rgba(255, 146, 4, 0.2), inset 0 1px 2px rgba(0, 0, 0, 0.4) !important;
}

.os-input::placeholder {
  color: #556274;
}

.os-periodo-group {
  display: flex;
  align-items: center;
  gap: 6px;
  margin: 0 !important;
}

.os-periodo-sep {
  color: #64748b;
  font-size: 0.8rem;
  font-weight: 600;
}

.btn-filter-search {
  height: 36px !important;
  min-height: 36px !important;
  max-height: 36px !important;
  line-height: 34px !important;
  padding: 0 18px !important;
  margin: 0 !important;
  margin-bottom: 0 !important;
  background: #1f2a38 !important;
  color: #dce3ec !important;
  border: 1px solid #334255 !important;
  border-radius: 5px !important;
  font-size: 0.85rem !important;
  font-weight: 600 !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  gap: 6px !important;
  cursor: pointer !important;
  transition: all 0.2s !important;
  white-space: nowrap !important;
  box-sizing: border-box !important;
}

.btn-filter-search:hover {
  background: #273546 !important;
  border-color: #ff9204 !important;
  color: #ffffff !important;
}

.btn-filter-search i {
  font-size: 1.1rem;
  color: #ff9204;
}

/* 3. Tabela Operacional de Ordens de Serviço */
.os-table-card {
  background: #141b22;
  border: 1px solid #232d3b;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
}

.os-table-wrapper {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

.os-table {
  width: 100% !important;
  border-collapse: separate !important;
  border-spacing: 0 !important;
  margin: 0 !important;
  font-size: 0.81rem;
}

.os-table thead th {
  background: #0f141a !important;
  color: #9aa7b8 !important;
  font-weight: 600 !important;
  font-size: 0.69rem !important;
  text-transform: uppercase !important;
  letter-spacing: 0.2px !important;
  padding: 9px 5px !important;
  border: none !important;
  border-bottom: 2px solid #232d3b !important;
  white-space: nowrap;
}

.os-table tbody td {
  padding: 8px 5px !important;
  border: none !important;
  border-bottom: 1px solid #1c2430 !important;
  color: #c9d2de !important;
  vertical-align: middle !important;
  background: transparent !important;
}

.os-table tbody tr:hover td {
  background: #19222c !important;
}

.os-table tbody tr:last-child td {
  border-bottom: none !important;
}

/* Alinhamento e Especificidade de Colunas */
.os-col-id {
  font-weight: 700;
  color: #7d8b9e !important;
  text-align: center;
  width: 50px;
}

.os-col-client {
  min-width: 190px;
  max-width: 250px;
}

.os-client-link {
  color: #e2e8f0 !important;
  font-weight: 600;
  text-decoration: none !important;
  display: block;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  transition: color 0.15s;
}

.os-client-link:hover {
  color: #ff9204 !important;
}

.os-col-resp {
  color: #94a3b8 !important;
  white-space: nowrap;
  max-width: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.os-col-date {
  text-align: center;
  white-space: nowrap;
  font-variant-numeric: tabular-nums;
  color: #a0aec0 !important;
  font-size: 0.81rem;
}

.os-col-money {
  text-align: right;
  white-space: nowrap;
  font-variant-numeric: tabular-nums;
  font-weight: 500;
  color: #cbd5e1 !important;
}

.os-col-money-highlight {
  font-weight: 700;
  color: #f1f5f9 !important;
}

.os-col-status {
  text-align: center;
  white-space: nowrap;
  width: 115px;
}

/* Badges Corporativos Elegantes (Sem Neon) */
.os-badge {
  display: inline-block;
  padding: 4px 9px;
  font-size: 0.72rem;
  font-weight: 600;
  border-radius: 4px;
  line-height: 1.1;
  text-transform: capitalize;
  letter-spacing: 0.2px;
  border: 1px solid transparent;
}

.os-badge-garantia {
  display: inline-block;
  padding: 3px 8px;
  font-size: 0.72rem;
  font-weight: 600;
  border-radius: 4px;
  line-height: 1.1;
}

.os-badge-garantia-valida {
  background: rgba(34, 197, 94, 0.12);
  color: #4ade80;
  border: 1px solid rgba(34, 197, 94, 0.25);
}

.os-badge-garantia-vencida {
  background: rgba(239, 68, 68, 0.12);
  color: #f87171;
  border: 1px solid rgba(239, 68, 68, 0.25);
}

.os-badge-garantia-sem {
  background: rgba(148, 163, 184, 0.1);
  color: #94a3b8;
  border: 1px solid rgba(148, 163, 184, 0.18);
}

/* Botões de Ação na Linha */
.os-actions-group {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  white-space: nowrap;
}

.os-action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 29px;
  height: 29px;
  border-radius: 4px;
  background: #1a232e;
  border: 1px solid #2a3747;
  color: #9aa7b8 !important;
  font-size: 15px;
  text-decoration: none !important;
  transition: all 0.15s ease-in-out;
  cursor: pointer;
}

.os-action-btn:hover {
  background: #253344;
  color: #ffffff !important;
  border-color: #3b4d63;
  transform: translateY(-1px);
}

.os-action-btn.btn-view:hover {
  color: #38bdf8 !important;
  border-color: #0284c7;
}

.os-action-btn.btn-print:hover {
  color: #fbbf24 !important;
  border-color: #d97706;
}

.os-action-btn.btn-edit:hover {
  color: #4ade80 !important;
  border-color: #16a34a;
}

.os-action-btn.btn-delete:hover {
  background: rgba(239, 68, 68, 0.18);
  color: #f87171 !important;
  border-color: #ef4444;
}

/* Dropdown de Ações Agrupadas na Linha */
.os-action-dropdown {
  position: relative;
  display: inline-block;
}

.os-action-dropdown-menu {
  position: absolute !important;
  top: 100% !important;
  right: 0 !important;
  left: auto !important;
  z-index: 1000 !important;
  min-width: 175px !important;
  padding: 6px 0 !important;
  margin: 4px 0 0 0 !important;
  list-style: none !important;
  background-color: #1a232f !important;
  border: 1px solid #2d3c4e !important;
  border-radius: 6px !important;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5) !important;
}

.os-action-dropdown-menu > li > a {
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
  padding: 8px 14px !important;
  clear: both !important;
  font-weight: 500 !important;
  font-size: 0.8rem !important;
  color: #cbd5e1 !important;
  white-space: nowrap !important;
  text-decoration: none !important;
  transition: all 0.15s ease !important;
}

.os-action-dropdown-menu > li > a:hover {
  background-color: #243142 !important;
  color: #ffffff !important;
}

.os-action-dropdown-menu > li > a i {
  font-size: 1.05rem !important;
  width: 16px !important;
  text-align: center !important;
}

.os-action-dropdown-menu .divider {
  height: 1px !important;
  margin: 5px 0 !important;
  background-color: #283749 !important;
  border: none !important;
}

/* Estilização do Modal de Exclusão */
#modal-excluir {
  background: #141c24 !important;
  border: 1px solid #283444 !important;
  color: #e2e8f0 !important;
  border-radius: 8px !important;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6) !important;
}

#modal-excluir .modal-header {
  background: #10161d !important;
  border-bottom: 1px solid #222c3a !important;
  padding: 12px 18px !important;
  border-radius: 8px 8px 0 0 !important;
}

#modal-excluir .modal-header h5 {
  color: #f1f5f9 !important;
  font-weight: 600 !important;
  margin: 0 !important;
}

#modal-excluir .modal-header .close {
  color: #94a3b8 !important;
  opacity: 0.8 !important;
  text-shadow: none !important;
  font-size: 22px !important;
}

#modal-excluir .modal-header .close:hover {
  color: #ffffff !important;
  opacity: 1 !important;
}

#modal-excluir .modal-body {
  padding: 24px 20px !important;
}

#modal-excluir .modal-footer {
  background: #10161d !important;
  border-top: 1px solid #222c3a !important;
  padding: 12px 18px !important;
  border-radius: 0 0 8px 8px !important;
  box-shadow: none !important;
}

/* Responsividade */
@media (max-width: 992px) {
  .os-filter-form {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 600px) {
  .os-filter-form {
    grid-template-columns: 1fr;
  }
  .os-header-container {
    flex-direction: column;
    align-items: flex-start;
  }
  .btn-amura-primary {
    width: 100%;
    justify-content: center;
  }
}
</style>

<div class="os-page-wrapper">

    <!-- 1. Cabeçalho Corporativo Amura: Título & Ação Primária -->
    <div class="os-header-container">
        <div class="os-title-area">
            <div class="os-title-icon">
                <i class="fas fa-diagnoses"></i>
            </div>
            <div class="os-title-text">
                <h2>Ordens de Serviço</h2>
                <p>Gerencie e acompanhe as ordens de serviço da empresa com controle operacional completo.</p>
            </div>
        </div>

        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')) { ?>
            <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="btn-amura-primary">
                <i class='bx bx-plus-circle'></i>
                <span>+ Nova Ordem de Serviço</span>
            </a>
        <?php } ?>
    </div>

    <!-- 2. Grupo de Filtros Organizado -->
    <div class="os-filter-card">
        <form method="get" action="<?php echo base_url(); ?>index.php/os/gerenciar" class="os-filter-form">
            <div class="os-filter-group">
                <label for="pesquisa" class="os-filter-label">Cliente</label>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar por nome do cliente..." class="os-input" value="<?=set_value('pesquisa')?>">
            </div>

            <div class="os-filter-group">
                <label for="status-filter" class="os-filter-label">Status</label>
                <select name="status" id="status-filter" class="os-select">
                    <option value="">Todos os status</option>
                    <option value="Aberto" <?=$this->input->get('status') == 'Aberto' ? 'selected' : ''?>>Aberto</option>
                    <option value="Faturado" <?=$this->input->get('status') == 'Faturado' ? 'selected' : ''?>>Faturado</option>
                    <option value="Negociação" <?=$this->input->get('status') == 'Negociação' ? 'selected' : ''?>>Negociação</option>
                    <option value="Em Andamento" <?=$this->input->get('status') == 'Em Andamento' ? 'selected' : ''?>>Em Andamento</option>
                    <option value="Orçamento" <?=$this->input->get('status') == 'Orçamento' ? 'selected' : ''?>>Orçamento</option>
                    <option value="Finalizado" <?=$this->input->get('status') == 'Finalizado' ? 'selected' : ''?>>Finalizado</option>
                    <option value="Cancelado" <?=$this->input->get('status') == 'Cancelado' ? 'selected' : ''?>>Cancelado</option>
                    <option value="Aguardando Peças" <?=$this->input->get('status') == 'Aguardando Peças' ? 'selected' : ''?>>Aguardando Peças</option>
                    <option value="Aprovado" <?=$this->input->get('status') == 'Aprovado' ? 'selected' : ''?>>Aprovado</option>
                </select>
            </div>

            <div class="os-filter-group">
                <label class="os-filter-label">Período</label>
                <div class="os-periodo-group">
                    <input type="text" name="data" autocomplete="off" id="data" placeholder="Data Inicial" class="os-input datepicker" value="<?=html_escape($this->input->get('data'))?>">
                    <span class="os-periodo-sep">até</span>
                    <input type="text" name="data2" autocomplete="off" id="data2" placeholder="Data Final" class="os-input datepicker" value="<?=html_escape($this->input->get('data2'))?>">
                </div>
            </div>

            <div class="os-filter-group os-filter-btn-wrap">
                <button type="submit" class="btn-filter-search" title="Aplicar filtros de pesquisa">
                    <i class='bx bx-search-alt'></i>
                    <span>Pesquisar</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 3. Tabela Corporativa de Resultados -->
    <div class="os-table-card">
        <div class="os-table-wrapper">
            <table class="os-table">
                <thead>
                    <tr>
                        <th class="os-col-id">N°</th>
                        <th>Cliente</th>
                        <th class="ph1">Responsável</th>
                        <th style="text-align:center;">Data Inicial</th>
                        <th class="ph2" style="text-align:center;">Data Final</th>
                        <th class="ph3" style="text-align:center;">Venc. Garantia</th>
                        <th style="text-align:right;">Valor Total</th>
                        <th style="text-align:right;">Valor c/ Desc.</th>
                        <th class="ph4" style="text-align:right;">V.T (Faturado)</th>
                        <th class="os-col-status">Status</th>
                        <th style="text-align:center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$results) { ?>
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 36px 20px; color: #718096;">
                                <i class='bx bx-file-blank' style="font-size: 2rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                                Nenhuma Ordem de Serviço encontrada para os critérios selecionados.
                            </td>
                        </tr>
                    <?php } else {
                        $this->load->model('os_model');
                        foreach ($results as $r) {
                            $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                            if ($r->dataFinal != null) {
                                $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                            } else {
                                $dataFinal = "-";
                            }
                            if ($this->input->get('pesquisa') === null && is_array(json_decode($configuration['os_status_list']))) {
                                if (in_array($r->status, json_decode($configuration['os_status_list'])) != true) {
                                    continue;
                                }
                            }

                            // Paleta Corporativa Sofisticada para Status
                            switch ($r->status) {
                                case 'Aberto':
                                    $bgStatus = 'rgba(34, 197, 94, 0.12)';
                                    $colorStatus = '#4ade80';
                                    $borderStatus = 'rgba(34, 197, 94, 0.28)';
                                    break;
                                case 'Em Andamento':
                                    $bgStatus = 'rgba(59, 130, 246, 0.12)';
                                    $colorStatus = '#60a5fa';
                                    $borderStatus = 'rgba(59, 130, 246, 0.28)';
                                    break;
                                case 'Orçamento':
                                    $bgStatus = 'rgba(217, 119, 6, 0.12)';
                                    $colorStatus = '#fbbf24';
                                    $borderStatus = 'rgba(217, 119, 6, 0.28)';
                                    break;
                                case 'Negociação':
                                    $bgStatus = 'rgba(234, 179, 8, 0.12)';
                                    $colorStatus = '#fde047';
                                    $borderStatus = 'rgba(234, 179, 8, 0.28)';
                                    break;
                                case 'Cancelado':
                                    $bgStatus = 'rgba(239, 68, 68, 0.12)';
                                    $colorStatus = '#f87171';
                                    $borderStatus = 'rgba(239, 68, 68, 0.28)';
                                    break;
                                case 'Finalizado':
                                    $bgStatus = 'rgba(14, 165, 233, 0.12)';
                                    $colorStatus = '#38bdf8';
                                    $borderStatus = 'rgba(14, 165, 233, 0.28)';
                                    break;
                                case 'Faturado':
                                    $bgStatus = 'rgba(168, 85, 247, 0.12)';
                                    $colorStatus = '#c084fc';
                                    $borderStatus = 'rgba(168, 85, 247, 0.28)';
                                    break;
                                case 'Aguardando Peças':
                                    $bgStatus = 'rgba(249, 115, 22, 0.12)';
                                    $colorStatus = '#fb923c';
                                    $borderStatus = 'rgba(249, 115, 22, 0.28)';
                                    break;
                                case 'Aprovado':
                                    $bgStatus = 'rgba(100, 116, 139, 0.16)';
                                    $colorStatus = '#cbd5e1';
                                    $borderStatus = 'rgba(100, 116, 139, 0.28)';
                                    break;
                                default:
                                    $bgStatus = 'rgba(148, 163, 184, 0.12)';
                                    $colorStatus = '#94a3b8';
                                    $borderStatus = 'rgba(148, 163, 184, 0.24)';
                                    break;
                            }

                            $vencGarantia = '';
                            $classeGarantia = 'os-badge-garantia-sem';
                            if ($r->garantia && is_numeric($r->garantia)) {
                                $vencGarantia = dateInterval($r->dataFinal, $r->garantia);
                            }
                            if (!empty($vencGarantia)) {
                                $dataGarantia = explode('/', $vencGarantia);
                                $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
                                if (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) {
                                    $classeGarantia = 'os-badge-garantia-valida';
                                } else {
                                    $classeGarantia = 'os-badge-garantia-vencida';
                                }
                            } elseif ($r->garantia == "0") {
                                $vencGarantia = 'Sem Garantia';
                                $classeGarantia = 'os-badge-garantia-sem';
                            } else {
                                $vencGarantia = '-';
                                $classeGarantia = 'os-badge-garantia-sem';
                            }
                    ?>
                        <tr>
                            <td class="os-col-id"><?= $r->idOs ?></td>
                            <td class="os-col-client cli1">
                                <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>" class="os-client-link" title="<?= html_escape($r->nomeCliente) ?>">
                                    <?= html_escape($r->nomeCliente) ?>
                                </a>
                            </td>
                            <td class="ph1 os-col-resp" title="<?= html_escape($r->nome) ?>">
                                <?= html_escape($r->nome) ?>
                            </td>
                            <td class="os-col-date"><?= $dataInicial ?></td>
                            <td class="ph2 os-col-date"><?= $dataFinal ?></td>
                            <td class="ph3 os-col-date">
                                <span class="os-badge-garantia <?= $classeGarantia ?>">
                                    <?= $vencGarantia ?>
                                </span>
                            </td>
                            <td class="os-col-money">R$ <?= number_format($r->totalProdutos + $r->totalServicos, 2, ',', '.') ?></td>
                            <td class="os-col-money os-col-money-highlight">R$ <?= number_format(floatval($r->valor_desconto), 2, ',', '.') ?></td>
                            <td class="ph4 os-col-money">R$ <?= number_format($r->faturado ? floatval($r->valor_desconto) : 0.00, 2, ',', '.') ?></td>
                            <td class="os-col-status">
                                <span class="os-badge" style="background-color: <?= $bgStatus ?>; color: <?= $colorStatus ?>; border-color: <?= $borderStatus ?>;">
                                    <?= $r->status ?>
                                </span>
                            </td>
                            <td>
                                <div class="os-actions-group">
                                    <?php
                                    $editavel = $this->os_model->isEditable($r->idOs);

                                    // Apenas Visualizar e Editar ficam visíveis diretamente
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) { ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $r->idOs ?>" class="os-action-btn btn-view" title="Visualizar Detalhes">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    <?php } ?>

                                    <?php if ($editavel) { ?>
                                        <a href="<?= base_url() ?>index.php/os/editar/<?= $r->idOs ?>" class="os-action-btn btn-edit" title="Editar OS">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    <?php } ?>

                                    <?php
                                    // Demais ações agrupadas em menu dropdown
                                    $temMaisAcoes = $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs') || 
                                                    ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs') && $editavel);
                                    if ($temMaisAcoes) { ?>
                                        <div class="os-action-dropdown dropdown">
                                            <a href="#" class="os-action-btn dropdown-toggle" data-toggle="dropdown" title="Mais Ações">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </a>
                                            <ul class="dropdown-menu os-action-dropdown-menu">
                                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) { ?>
                                                    <li>
                                                        <a href="<?= base_url() ?>index.php/os/imprimir/<?= $r->idOs ?>" target="_blank">
                                                            <i class="bx bx-printer" style="color: #fbbf24;"></i>
                                                            <span>Imprimir A4</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url() ?>index.php/os/imprimirTermica/<?= $r->idOs ?>" target="_blank">
                                                            <i class="bx bx-receipt" style="color: #38bdf8;"></i>
                                                            <span>Imprimir Cupom Térmico</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs') && $editavel) { ?>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="#modal-excluir" role="button" data-toggle="modal" os="<?= $r->idOs ?>" style="color: #f87171 !important;">
                                                            <i class="bx bx-trash-alt" style="color: #ef4444;"></i>
                                                            <span>Excluir Ordem de Serviço</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    <div style="display: flex; justify-content: center; margin-top: 10px;">
        <?php echo $this->pagination->create_links(); ?>
    </div>

    <!-- Modal de Exclusão Preservado -->
    <div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="<?php echo base_url() ?>index.php/os/excluir" method="post" style="margin: 0;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 id="myModalLabel"><i class='bx bx-trash' style="color: #ef4444; margin-right: 6px;"></i> Excluir Ordem de Serviço</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idOs" name="id" value="" />
                <p style="text-align: center; font-size: 0.95rem; color: #cbd5e1; margin: 10px 0;">Deseja realmente excluir esta Ordem de Serviço?</p>
                <p style="text-align: center; font-size: 0.8rem; color: #ef4444; margin: 0;">Esta ação é permanente e removerá o registro do sistema.</p>
            </div>
            <div class="modal-footer" style="display:flex; justify-content: center; gap: 10px;">
                <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true" style="padding: 6px 16px; border-radius: 5px;">
                    <i class="bx bx-x"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-danger" style="padding: 6px 18px; border-radius: 5px; background: #dc2626; border-color: #b91c1c;">
                    <i class='bx bx-trash'></i> Confirmar Exclusão
                </button>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var os = $(this).attr('os');
            if (os) {
                $('#idOs').val(os);
            }
        });

        $(document).on('click', '#excluir-notificacao', function(event) {
            event.preventDefault();
            $.ajax({
                    url: '<?php echo site_url() ?>/os/excluir_notificacao',
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    if (data.result == true) {
                        Swal.fire({
                            type: "success",
                            title: "Sucesso",
                            text: "Notificação excluída com sucesso."
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            type: "error",
                            title: "Erro",
                            text: "Ocorreu um problema ao tentar excluir notificação."
                        });
                    }
                });
        });

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });
</script>

