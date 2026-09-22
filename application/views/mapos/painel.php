<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/dist/excanvas.min.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?= base_url(); ?>assets/js/dist/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>
<script src='<?= base_url(); ?>assets/js/fullcalendar.min.js'></script>
<script src='<?= base_url(); ?>assets/js/fullcalendar/locales/pt-br.js'></script>

<link href='<?= base_url(); ?>assets/css/fullcalendar.min.css' rel='stylesheet' />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/dist/jquery.jqplot.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

<!-- New Bem-vindos -->
<div id="content-bemv">
    <div class="bemv">Dashboard</div>
    <div></div>
</div>

<!-- Action boxes -->
<ul class="cardBox">
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) : ?>
        <li class="card card-shortcut card-shortcut-clientes">
            <a class="cardLink" href="<?= site_url('clientes') ?>">
                <div class="shortcut-icon-wrapper">
                    <i class='bx bx-user'></i>
                </div>
                <div class="shortcut-title numbers N-tittle">Clientes</div>
                <div class="shortcut-badge cardName">F1</div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) : ?>
        <li class="card card-shortcut card-shortcut-produtos">
            <a class="cardLink" href="<?= site_url('produtos') ?>">
                <div class="shortcut-icon-wrapper">
                    <i class='bx bx-package'></i>
                </div>
                <div class="shortcut-title numbers N-tittle">Produtos</div>
                <div class="shortcut-badge cardName">F2</div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) : ?>
        <li class="card card-shortcut card-shortcut-servicos">
            <a class="cardLink" href="<?= site_url('servicos') ?>">
                <div class="shortcut-icon-wrapper">
                    <i class='bx bx-wrench'></i>
                </div>
                <div class="shortcut-title numbers N-tittle">Serviços</div>
                <div class="shortcut-badge cardName">F3</div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
        <li class="card card-shortcut card-shortcut-os">
            <a class="cardLink" href="<?= site_url('os') ?>">
                <div class="shortcut-icon-wrapper">
                    <i class='bx bx-notepad'></i>
                </div>
                <div class="shortcut-title numbers N-tittle">Ordens de<br>Serviço</div>
                <div class="shortcut-badge cardName">F4</div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) : ?>
        <li class="card card-shortcut card-shortcut-vendas">
            <a class="cardLink" href="<?= site_url('vendas/') ?>">
                <div class="shortcut-icon-wrapper">
                    <i class='bx bx-cart'></i>
                </div>
                <div class="shortcut-title numbers N-tittle">Vendas</div>
                <div class="shortcut-badge cardName">F6</div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')) : ?>
        <li class="card card-shortcut card-shortcut-lancamentos">
            <a class="cardLink" href="<?= site_url('financeiro/lancamentos') ?>">
                <div class="shortcut-icon-wrapper">
                    <i class='bx bx-bar-chart-alt-2'></i>
                </div>
                <div class="shortcut-title numbers N-tittle">Lançamentos</div>
                <div class="shortcut-badge cardName">F7</div>
            </a>
        </li>
    <?php endif ?>
</ul>
<!-- End-Action boxes -->

<div class="row-fluid" style="margin-top: 0; display: flex">
    <div class="Sspan12">
        <div class="widget-box2">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; border-bottom: 1px solid #323248;">
                <h5 class="cardHeader" style="margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bx bx-calendar-event" style="color: #ff9204; font-size: 20px;"></i>
                    <span>Agenda & Operações</span>
                </h5>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" class="btn btn-mini btn-primary" id="btn-novo-compromisso" style="display: flex; align-items: center; gap: 4px; border-radius: 6px;">
                        <i class="bx bx-plus-circle"></i> <span>Novo Compromisso</span>
                    </button>
                </div>
            </div>
            <div class="widget-content" style="padding: 12px;">
                <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 12px; background: rgba(255,255,255,0.03); padding: 8px 12px; border-radius: 8px; border: 1px solid #2e2e42;">
                    <!-- Filtro Tipo de Exibição -->
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-size: 11.5px; color: #a2a3b7; font-weight: 600;">Exibir:</span>
                        <select id="filtroTipoAgenda" class="span12" style="margin-bottom: 0; height: 30px; font-size: 12px; width: 155px; border-radius: 6px; background: #1a1a27; color: #fff; border-color: #3b3b54;">
                            <option value="todos">⚡ Todos os Eventos</option>
                            <option value="os">🛠️ Apenas OS</option>
                            <option value="financeiro">💳 Vencimentos (Contas)</option>
                            <option value="compromissos">📌 Compromissos</option>
                        </select>
                    </div>

                    <!-- Filtro Status OS -->
                    <div id="wrapperFiltroStatus" style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-size: 11.5px; color: #a2a3b7; font-weight: 600;">Status OS:</span>
                        <select id="statusOsGet" class="span12" style="margin-bottom: 0; height: 30px; font-size: 12px; width: 160px; border-radius: 6px; background: #1a1a27; color: #fff; border-color: #3b3b54;">
                            <option value="">Todos os Status</option>
                            <option value="Aberto">Aberto</option>
                            <option value="Faturado">Faturado</option>
                            <option value="Negociação">Negociação</option>
                            <option value="Orçamento">Orçamento</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Aguardando Peças">Aguardando Peças</option>
                            <option value="Aprovado">Aprovado</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-mini btn-info" id="btn-calendar" style="height: 30px; border-radius: 6px; display: flex; align-items: center; gap: 4px;">
                        <i class="bx bx-sync"></i> <span>Atualizar</span>
                    </button>

                    <div style="margin-left: auto; font-size: 11px; color: #8c8c9e; display: flex; gap: 10px; align-items: center;">
                        <span style="display: inline-flex; align-items: center; gap: 4px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: #436eee;"></span> OS</span>
                        <span style="display: inline-flex; align-items: center; gap: 4px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span> Receita</span>
                        <span style="display: inline-flex; align-items: center; gap: 4px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444;"></span> Despesa</span>
                        <span style="display: inline-flex; align-items: center; gap: 4px;"><span style="width: 8px; height: 8px; border-radius: 50%; background: #ff9204;"></span> Compromisso</span>
                        <span title="Dica: Você pode arrastar eventos para reagendar datas!" style="cursor: help;"><i class="bx bx-help-circle" style="font-size: 14px; color: #a2a3b7;"></i></span>
                    </div>
                </div>

                <div id='source-calendar'></div>
            </div>
        </div>

        <!-- New widget right -->
        <div class="new-statisc">
            <div class="widget-box-new widbox-blak" style="height:100%">
                <div>
                    <h5 class="cardHeader">Estatísticas do Sistema</h5>
                </div>

                <div class="new-bottons">
                    <a href="<?php echo base_url(); ?>index.php/clientes/adicionar" class="card tip-top" title="Add Clientes e Fornecedores">
                        <div><i class='bx bxs-group iconBx'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('clientes'); ?></div>
                            <div class="cardName">Clientes</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>index.php/produtos/adicionar" class="card tip-top" title="Adicionar Produtos">
                        <div><i class='bx bxs-package iconBx2'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('produtos'); ?></div>
                            <div class="cardName">Produtos</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url() ?>index.php/servicos/adicionar" class="card tip-top" title="Adicionar serviços">
                        <div><i class='bx bxs-stopwatch iconBx3'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('servicos'); ?></div>
                            <div class="cardName">Serviços</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="card tip-top" title="Adicionar OS">
                        <div><i class='bx bxs-spreadsheet iconBx4'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('os'); ?></div>
                            <div class="cardName">OS</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>index.php/garantias" class="card tip-top" title="Adicionar garantia">
                        <div><i class='bx bxs-receipt iconBx6'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('garantias'); ?></div>
                            <div class="cardName">Garantias</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url() ?>index.php/vendas/adicionar" class="card tip-top" title="Adicionar Vendas">
                        <div><i class='bx bxs-cart-alt iconBx5'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('vendas'); ?></div>
                            <div class="cardName">Vendas</div>
                        </div>
                    </a>

                    <!-- responsavel por fazer complementar a variavel "$financeiro_mes_dia->" de receita e despesa -->
                    <?php if ($estatisticas_financeiro != null) {
                        if ($estatisticas_financeiro->total_receita != null || $estatisticas_financeiro->total_despesa != null || $estatisticas_financeiro->total_receita_pendente != null || $estatisticas_financeiro->total_despesa_pendente != null) {  ?>

                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'rFinanceiro')) : ?>
                                <?php $diaRec = "VALOR_" . date('m') . "_REC";
                                $diaDes = "VALOR_" . date('m') . "_DES"; ?>

                                <a href="<?php echo base_url() ?>index.php/financeiro/lancamentos" class="card tip-top" title="Adicionar receita">
                                    <div><i class='bx bxs-up-arrow-circle iconBx7'></i></div>
                                    <div>
                                        <div class="cardName1 cardName2">R$ <?php echo number_format(($financeiro_mes_dia->$diaRec - $financeiro_mes_dia->$diaDes), 2, ',', '.'); ?></div>
                                        <div class="cardName">Receita do dia</div>
                                    </div>
                                </a>

                                <a href="<?php echo base_url() ?>index.php/financeiro/lancamentos" class="card tip-top" title="Adiciona despesa">
                                    <div><i class='bx bxs-down-arrow-circle iconBx8'></i></div>
                                    <div>
                                        <div class="cardName1 cardName2">R$ <?php echo number_format(($financeiro_mes_dia->$diaDes ? $financeiro_mes_dia->$diaDes : 0), 2, ',', '.'); ?></div>
                                        <div class="cardName">Despesa do dia</div>
                                    </div>
                                </a>
                            <?php endif ?>

                    <?php  }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim new widget right -->

<?php if ($estatisticas_financeiro != null) {
    if ($estatisticas_financeiro->total_receita != null || $estatisticas_financeiro->total_despesa != null || $estatisticas_financeiro->total_receita_pendente != null || $estatisticas_financeiro->total_despesa_pendente != null) {  ?>

        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'rFinanceiro')) : ?>
            <!-- Start Charts -->
            <div class="new-balance">
                <div class="widget-box0">
                    <div class="widget-title2">
                        <h5 class="cardHeader">Balanço Mensal do Ano</h5>
                        <form method="get" style="display:flex;margin-right:18px;justify-content:flex-end">
                            <input type="number" name="year" style="width:65px;margin-left:17px;margin-bottom:25px;margin-top:10px;padding-left: 35px" value="<?php echo intval(preg_replace('/[^0-9]/', '', $this->input->get('year'))) ?: date('Y') ?>">
                            <button type="submit" class="btn-xsx"><i class='bx bx-search iconX'></i></button>
                        </form>
                    </div>
                    <div class="widget-content" style="padding:10px 25px 5px 25px">
                        <div class="row-fluid" style="margin-top:-35px;">
                            <div class="span12">
                                <canvas id="myChart" style="overflow-x: scroll;margin-left: -14px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-box-statist">
                    <h5 class="cardHeader">Estatísticas Financeira</h5>
                    <div class="widget-content" style="padding:15px;margin:15px 0 0; position: relative; height: 320px;">
                        <canvas id="statusOS"></canvas>
                    </div>
                </div>
            </div>
        <?php endif ?>

<script type="text/javascript">
    if (window.outerWidth > 2000) {
        Chart.defaults.font.size = 15;
    };
    if (window.outerWidth < 2000 && window.outerWidth > 1367) {
        Chart.defaults.font.size = 11;
    };
    if (window.outerWidth < 1367 && window.outerWidth > 480) {
        Chart.defaults.font.size = 9.5;
    };
    if (window.outerWidth < 480) {
        Chart.defaults.font.size = 8.5;
    };

    var ctx = document.getElementById('myChart').getContext('2d');
    var StatusOS = document.getElementById('statusOS').getContext('2d');

    var myChart = new Chart(ctx, {
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                    label: 'Receita Líquida',
                    data: [<?php echo($financeiro_mes->VALOR_JAN_REC - $financeiro_mes->VALOR_JAN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_FEV_REC - $financeiro_mes->VALOR_FEV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAR_REC - $financeiro_mes->VALOR_MAR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_ABR_REC - $financeiro_mes->VALOR_ABR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAI_REC - $financeiro_mes->VALOR_MAI_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUN_REC - $financeiro_mes->VALOR_JUN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUL_REC - $financeiro_mes->VALOR_JUL_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_AGO_REC - $financeiro_mes->VALOR_AGO_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_SET_REC - $financeiro_mes->VALOR_SET_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_OUT_REC - $financeiro_mes->VALOR_OUT_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_NOV_REC - $financeiro_mes->VALOR_NOV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_DEZ_REC - $financeiro_mes->VALOR_DEZ_DES); ?>
                    ],

                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderRadius: 15,
                },

                {
                    label: 'Receita Bruta',
                    data: [<?php echo($financeiro_mes->VALOR_JAN_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_FEV_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_MAR_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_ABR_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_MAI_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_JUN_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_JUL_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_AGO_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_SET_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_OUT_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_NOV_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_DEZ_REC); ?>
                    ],

                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderRadius: 15,
                },

                {
                    label: 'Despesas',
                    data: [<?php echo($financeiro_mes->VALOR_JAN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_FEV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_ABR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAI_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUL_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_AGO_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_SET_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_OUT_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_NOV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_DEZ_DES); ?>
                    ],

                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderRadius: 15,
                },

                {
                    label: 'Inadimplência',
                    data: [<?php echo($financeiro_mesinadipl->VALOR_JAN_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_FEV_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_MAR_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_ABR_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_MAI_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_JUN_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_JUL_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_AGO_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_SET_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_OUT_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_NOV_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_DEZ_REC); ?>
                    ],

                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderRadius: 15,
                }
            ]

        },
        // configuração
        type: 'bar',
        options: {
            locale: 'pt-BR',
            scales: {
                y: {
                    ticks: {
                        callback: (value, index, values) => {
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                maximumSignificantDidits: 1
                            }).format(value);
                        }
                    }
                },
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Meses'
                    }
                }
            },

            plugins: {
                tooltip: {
                    callbacks: {
                        beforeTitle: function(context) {
                            return 'Referente ao mês de';
                        }
                    }
                },

                legend: {
                    position: "bottom",
                    labels: {
                        usePointStyle: true,
                    }
                }
            }
        }
    });

    var myChartStatus = new Chart(StatusOS, {
        type: 'bar',
        data: {
            labels: [
                'Receita Realizada',
                'Receita Pendente',
                'Saldo em Caixa',
                'Despesa Realizada',
                'Despesa Pendente',
                'Saldo a Entrar'
            ],
            datasets: [{
                label: 'Valor (R$)',
                data: [
                    <?php echo ($estatisticas_financeiro->total_receita != null) ?  $estatisticas_financeiro->total_receita : '0.00'; ?>,
                    <?php echo ($estatisticas_financeiro->total_receita_pendente != null) ?  $estatisticas_financeiro->total_receita_pendente : '0.00'; ?>,
                    <?php echo($estatisticas_financeiro->total_receita - $estatisticas_financeiro->total_despesa); ?>,
                    <?php echo ($estatisticas_financeiro->total_despesa != null) ?  $estatisticas_financeiro->total_despesa : '0.00'; ?>,
                    <?php echo ($estatisticas_financeiro->total_despesa_pendente != null) ?  $estatisticas_financeiro->total_despesa_pendente : '0.00'; ?>,
                    <?php echo($estatisticas_financeiro->total_receita_pendente - $estatisticas_financeiro->total_despesa_pendente); ?>
                ],

                backgroundColor: [
                    'rgba(46, 204, 113, 0.75)',
                    'rgba(52, 152, 219, 0.75)',
                    'rgba(155, 89, 182, 0.75)',
                    'rgba(231, 76, 60, 0.75)',
                    'rgba(230, 126, 34, 0.75)',
                    'rgba(241, 196, 15, 0.75)'
                ],
                borderColor: [
                    '#2ecc71',
                    '#3498db',
                    '#9b59b6',
                    '#e74c3c',
                    '#e67e22',
                    '#f1c40f'
                ],
                borderWidth: 1.5,
                borderRadius: 6
            }]
        },

        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            locale: 'pt-BR',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var value = context.raw || 0;
                            return ' Total: ' + new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }).format(value);
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                maximumFractionDigits: 0
                            }).format(value);
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            weight: '600'
                        }
                    }
                }
            }
        }
    });

    function responsiveFonts() {
        myChart.update();
    }
</script>
<?php  }
} ?>
</div>
</div>

<!-- Start Staus OS -->
<div class="span12A" style="margin-left: 0">
    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Em Orçamento.</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_orcamentos != null) : ?>
                        <?php foreach ($ordens_orcamentos as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>

                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar">
                                            <i class="bx bx-show"></i> </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS em Orçamento.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Em Aberto</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_abertas != null) : ?>
                        <?php foreach ($ordens_abertas as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>
                                
                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar">
                                            <i class="bx bx-show"></i> </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS em aberto.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Aprovadas</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_aprovadas != null) : ?>
                        <?php foreach ($ordens_aprovadas as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>
                                
                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar">
                                            <i class="bx bx-show"></i> </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS Aprovada.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Finalizadas</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_finalizadas != null) : ?>
                        <?php foreach ($ordens_finalizadas as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>
                                
                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar">
                                            <i class="bx bx-show"></i> </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS Finalizada.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Em Andamento e Aguardando Peças</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_status != null) : ?>
                        <?php foreach ($ordens_status as $o) : ?>
                                <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>
                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>

                                    <td>
                                        <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                    </td>
                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar">
                                            <i class="bx bx-show"></i> </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS em Orçamento.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Status de Vendas</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered lanc-table">
                <thead>
                    <tr>
                        <th class="numero-col">N°</th>
                        <th class="cliente-col">Cliente</th>
                        <th class="data-final-col">Data da Venda</th>
                        <th class="status-col">Status</th>
                        <th class="acoes-col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($vendasstatus != null) : ?>
                        <?php foreach ($vendasstatus as $v) : ?>
                            <?php
                                    switch ($v->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $v->idVendas ?>
                                </td>

                                <td class="cli1">
                                    <?= $v->nomeCliente ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($v->dataVenda)) ?>
                                </td>
                                
                                    <td>
                                        <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $v->status ?></span>
                                    </td>
                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) : ?>
                                        <a href="<?= base_url() ?>index.php/vendas/visualizar/<?= $v->idVendas ?>" class="btn-nwe tip-top" title="Visualizar">
                                            <i class="bx bx-show"></i> </a>
                                   
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma Venda.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Últimos Lançamentos Pendentes</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered lanc-table">
                <thead>
                    <tr>
                        <th class="tipo-col">Tipo</th>
                        <th class="cliente-col">Cliente/Fornecedor</th>
                        <th class="descricao-col">Descrição</th>
                        <th class="vencimento-col">Vencimento</th>
                        <th class="valor-col">V.T. Faturado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lancamentos)): ?>
                        <?php foreach ($lancamentos as $lancamento): ?>
                            <tr>
                                <td>
                                    <?php if ($lancamento->tipo == 'receita'): ?>
                                        <span class="label label-success"><b><?php echo ucfirst($lancamento->tipo); ?></b></span>
                                    <?php elseif ($lancamento->tipo == 'despesa'): ?>
                                        <span class="label label-important"><b><?php echo ucfirst($lancamento->tipo); ?></b></span>
                                    <?php else: ?>
                                        <?php echo ucfirst($lancamento->tipo); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-truncate"><?php echo $lancamento->cliente_fornecedor; ?></td>
                                <td class="text-truncate"><?php echo $lancamento->descricao; ?></td>
                                <td><?php echo date_format(date_create($lancamento->data_vencimento), 'd/m/Y'); ?></td>
                                <td>R$ <?php echo number_format($lancamento->valor_desconto, 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhum lançamento encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Produtos Com Estoque Mínimo</h5>
        </div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Produto</th>
                            <th>Preço de Venda</th>
                            <th>Estoque</th>
                            <th class="ph3">Estoque Mínimo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($produtos != null) : ?>
                            <?php foreach ($produtos as $p) : ?>
                                <tr>
                                    <td>
                                        <?= $p->idProdutos ?>
                                    </td>
                                    <td class="cli1">
                                        <?= $p->descricao ?>
                                    </td>
                                    <td>R$
                                        <?= $p->precoVenda ?>
                                    </td>
                                    <td>
                                        <?= $p->estoque ?>
                                    </td>
                                    <td class="ph3">
                                        <?= $p->estoqueMinimo ?>
                                    </td>
                                    <td>
                                        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) : ?>
                                            <a href="<?= base_url() ?>index.php/produtos/editar/<?= $p->idProdutos ?>" class="btn-nwe3 tip-top" title="Editar">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="#atualizar-estoque" role="button" data-toggle="modal" produto="<?= $p->idProdutos ?>" estoque="<?= $p->estoque ?>" class="btn-nwe5 tip-top" title="Atualizar Estoque">
                                                <i class="bx bx-plus-circle"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">Nenhum produto com estoque baixo.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>

</div>
<!-- Fim Staus OS -->

<!-- Modal Opções ao Clicar no Dia -->
<div id="modalAcaoDia" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="max-width: 440px; border-radius: 10px; background: #1e1e2d;">
    <div class="modal-header" style="border-bottom: 1px solid #323248;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff;">×</button>
        <h4 style="color: #fff; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="bx bx-calendar-plus" style="color: #ff9204;"></i> <span id="labelDataSelecionada">Dia Selecionado</span>
        </h4>
    </div>
    <div class="modal-body" style="padding: 20px; text-align: center;">
        <p style="color: #a2a3b7; font-size: 13px; margin-bottom: 20px;">O que você deseja registrar para esta data?</p>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="#" id="btnAcaoCriarOs" class="button btn btn-primary btn-large" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px; border-radius: 8px;">
                <i class="bx bx-wrench" style="font-size: 20px;"></i>
                <span style="font-size: 14px; font-weight: 600;">Abrir Nova Ordem de Serviço</span>
            </a>
            <button type="button" id="btnAcaoCriarCompromisso" class="button btn btn-warning btn-large" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px; border-radius: 8px;">
                <i class="bx bx-pin" style="font-size: 20px;"></i>
                <span style="font-size: 14px; font-weight: 600;">Agendar Compromisso / Lembrete</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Novo Compromisso -->
<div id="modalNovoCompromisso" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="max-width: 500px; border-radius: 10px; background: #1e1e2d;">
    <form id="formNovoCompromisso" style="margin: 0;">
        <div class="modal-header" style="border-bottom: 1px solid #323248;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff;">×</button>
            <h4 style="color: #fff; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="bx bx-calendar-plus" style="color: #ff9204;"></i> Agendar Compromisso / Lembrete
            </h4>
        </div>
        <div class="modal-body" style="padding: 20px;">
            <div class="control-group" style="margin-bottom: 14px;">
                <label style="color: #cbd5e1; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Título do Compromisso / Lembrete *</label>
                <input type="text" id="comp_titulo" name="titulo" required placeholder="Ex: Visita técnica, Entrega do aparelho, etc." class="span12" style="background: #151521; border-color: #2e2e42; color: #fff; border-radius: 6px; padding: 8px 10px; height: auto;">
            </div>

            <div class="row-fluid" style="margin-bottom: 14px;">
                <div class="span6">
                    <label style="color: #cbd5e1; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Data *</label>
                    <input type="date" id="comp_data" name="data_inicio" required class="span12" style="background: #151521; border-color: #2e2e42; color: #fff; border-radius: 6px; padding: 6px 10px; height: auto;">
                </div>
                <div class="span6">
                    <label style="color: #cbd5e1; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Horário</label>
                    <input type="time" id="comp_hora" name="hora_inicio" value="09:00" class="span12" style="background: #151521; border-color: #2e2e42; color: #fff; border-radius: 6px; padding: 6px 10px; height: auto;">
                </div>
            </div>

            <div class="control-group" style="margin-bottom: 14px;">
                <label style="color: #cbd5e1; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Cor de Destaque</label>
                <select id="comp_cor" name="cor" class="span12" style="background: #151521; border-color: #2e2e42; color: #fff; border-radius: 6px; height: 36px;">
                    <option value="#ff9204" style="background: #ff9204; color: #fff;">Laranja (Padrão)</option>
                    <option value="#3699ff" style="background: #3699ff; color: #fff;">Azul (Visita / Atendimento)</option>
                    <option value="#10b981" style="background: #10b981; color: #fff;">Verde (Concluído / Prioridade Baixa)</option>
                    <option value="#ef4444" style="background: #ef4444; color: #fff;">Vermelho (Urgente / Alerta)</option>
                    <option value="#8b5cf6" style="background: #8b5cf6; color: #fff;">Roxo (Retorno / Garantia)</option>
                </select>
            </div>

            <div class="control-group" style="margin-bottom: 0;">
                <label style="color: #cbd5e1; font-weight: 600; font-size: 12px; margin-bottom: 4px;">Descrição / Observações</label>
                <textarea id="comp_descricao" name="descricao" rows="3" placeholder="Informações adicionais, detalhes do cliente, etc." class="span12" style="background: #151521; border-color: #2e2e42; color: #fff; border-radius: 6px;"></textarea>
            </div>
        </div>
        <div class="modal-footer" style="background: #191924; border-top: 1px solid #323248; display: flex; justify-content: flex-end; gap: 8px;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnSalvarCompromisso" class="btn btn-success">Salvar Compromisso</button>
        </div>
    </form>
</div>

<!-- Modal Status OS / Evento Calendar -->
<div id="calendarModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 10px; background: #1e1e2d;">
    <div class="modal-header" style="border-bottom: 1px solid #323248;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff;">×</button>
        <h3 id="myModalLabel" style="color: #fff; margin: 0;">Detalhes do Evento</h3>
    </div>
    <div class="modal-body" style="color: #e4e6ef;">
        <!-- Bloco para OS -->
        <div id="corpoModalOs">
            <h4><b>OS:</b> <span id="modalId" class="modal-id"></span></h4>
            <h5 id="modalCliente" class="modal-cliente" style="color: #ff9204;"></h5>
            <div id="modalDataInicial" class="modal-DataInicial"></div>
            <div id="modalDataFinal" class="modal-DataFinal"></div>
            <div id="modalGarantia" class="modal-Garantia"></div>
            <div id="modalStatus" class="modal-Status"></div>
            <div id="modalDescription" class="modal-Description"></div>
            <div id="modalDefeito" class="modal-Defeito"></div>
            <div id="modalObservacoes" class="modal-Observacoes"></div>
            <div id="modalSubtotal" class="modal-Subtotal"></div>
            <div id="modalDesconto" class="modal-Desconto"></div>
            <div id="modalTotal" class="modal-Total" style="font-weight: 700; color: #10b981;"></div>
            <div id="modalFaturado" class="modal-Faturado"></div>
        </div>

        <!-- Bloco para Compromisso -->
        <div id="corpoModalCompromisso" style="display: none;">
            <h4 id="compDetalheTitulo" style="color: #ff9204; margin-top: 0;"></h4>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Data e Hora:</b> <span id="compDetalheData"></span></div>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Responsável:</b> <span id="compDetalheUsuario"></span></div>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Status:</b> <span id="compDetalheStatus" class="badge badge-warning"></span></div>
            <div style="margin-top: 12px; padding: 10px; background: #151521; border-radius: 6px; border: 1px solid #2e2e42;">
                <b style="color: #a2a3b7; display: block; margin-bottom: 4px;">Observações:</b>
                <span id="compDetalheDescricao" style="font-size: 13px; line-height: 1.4;"></span>
            </div>
        </div>

        <!-- Bloco para Financeiro -->
        <div id="corpoModalFinanceiro" style="display: none;">
            <h4 id="finDetalheTipo" style="margin-top: 0;"></h4>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Cliente / Fornecedor:</b> <span id="finDetalheCliente" style="color: #fff; font-weight: 600;"></span></div>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Vencimento:</b> <span id="finDetalheVencimento"></span></div>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Valor:</b> <span id="finDetalheValor" style="font-size: 16px; font-weight: 700;"></span></div>
            <div style="margin-bottom: 8px;"><b style="color: #a2a3b7;">Situação:</b> <span id="finDetalheStatus"></span></div>
            <div style="margin-top: 12px; padding: 10px; background: #151521; border-radius: 6px; border: 1px solid #2e2e42;">
                <b style="color: #a2a3b7; display: block; margin-bottom: 4px;">Descrição:</b>
                <span id="finDetalheDescricao" style="font-size: 13px;"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="background: #191924; border-top: 1px solid #323248; display: flex; justify-content: flex-end; gap: 8px;">
        <!-- Ações OS -->
        <div id="acoesModalOs" style="display: flex; gap: 6px;">
            <?php
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                    echo '<a id="modalIdVisualizar" href="" class="btn tip-top" title="Ver mais detalhes"><i class="fas fa-eye"></i> Visualizar</a>';
                }
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                    echo '<a id="modalIdEditar" href="" class="btn btn-info tip-top" title="Editar OS"><i class="fas fa-edit"></i> Editar</a>';
                }
                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
                    echo '<a id="linkExcluir" href="#modal-excluir-os" role="button" data-toggle="modal" os="" class="btn btn-danger tip-top" title="Excluir OS"><i class="fas fa-trash-alt"></i></a>';
                }
            ?>
        </div>

        <!-- Ações Compromisso -->
        <div id="acoesModalCompromisso" style="display: none;">
            <button type="button" id="btnExcluirCompromisso" class="btn btn-danger"><i class="bx bx-trash"></i> Excluir Compromisso</button>
        </div>

        <!-- Fechar Geral -->
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    </div>
</div>

<!-- Modal Excluir Os -->
<div id="modal-excluir-os" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/os/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir OS</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="modalIdExcluir" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta OS?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<!-- Modal Estoque -->
<div id="atualizar-estoque" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/produtos/atualizar_estoque" method="post" id="formEstoque">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="fas fa-plus-square"></i> Atualizar Estoque</h5>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label for="estoqueAtual" class="control-label">Estoque Atual</label>
                <div class="controls">
                    <input id="estoqueAtual" type="text" name="estoqueAtual" value="" readonly />
                </div>
            </div>

            <div class="control-group">
                <label for="estoque" class="control-label">Adicionar Produtos<span class="required">*</span></label>
                <div class="controls">
                    <input type="hidden" id="idProduto" class="idProduto" name="id" value="" />
                    <input id="estoque" type="text" name="estoque" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<!-- Modal Estoque-->
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
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
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        var dataClicadaTemp = null;
        var idCompromissoAtivo = null;

        var srcCalendarEl = document.getElementById('source-calendar');
        var srcCalendar = new FullCalendar.Calendar(srcCalendarEl, {
            locale: 'pt-br',
            height: 540,
            editable: true,
            selectable: true,
            businessHours: true,
            dayMaxEvents: 3,
            displayEventTime: false,
            events: {
                url: "<?= site_url('sistema/calendario'); ?>",
                method: 'GET',
                extraParams: function() {
                    return {
                        tipo: $("#filtroTipoAgenda").val(),
                        status: $("#statusOsGet").val(),
                    };
                },
                failure: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao carregar eventos da agenda',
                        timer: 3000,
                        showConfirmButton: false
                    });
                },
            },
            // Clique em data vazia -> Abre opções
            dateClick: function(info) {
                dataClicadaTemp = info.dateStr;
                $('#labelDataSelecionada').html('Data: ' + info.dateStr.split('-').reverse().join('/'));
                $('#btnAcaoCriarOs').attr('href', '<?= site_url("os/adicionar") ?>?dataFinal=' + info.dateStr);
                $('#modalAcaoDia').modal('show');
            },
            // Arrastar e soltar para reprogramar prazo
            eventDrop: function(info) {
                var eventProps = info.event.extendedProps;
                var novaDataStr = info.event.start.toISOString().slice(0, 10);
                
                if (eventProps.tipo === 'financeiro') {
                    info.revert();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Aviso',
                        text: 'Vencimentos financeiros devem ser alterados diretamente no módulo financeiro.',
                        timer: 3500
                    });
                    return;
                }

                Swal.fire({
                    title: 'Reprogramar Data?',
                    text: 'Deseja alterar a data deste evento para ' + novaDataStr.split('-').reverse().join('/') + '?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff9204',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, reprogramar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "<?= site_url('sistema/reprogramarDataAjax'); ?>",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                tipo: eventProps.tipo,
                                id: eventProps.rawId,
                                novaData: novaDataStr
                            },
                            success: function(resp) {
                                if (resp.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: resp.message,
                                        timer: 2500,
                                        showConfirmButton: false
                                    });
                                } else {
                                    info.revert();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro',
                                        text: resp.message || 'Não foi possível reprogramar.'
                                    });
                                }
                            },
                            error: function() {
                                info.revert();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: 'Falha na comunicação com o servidor.'
                                });
                            }
                        });
                    } else {
                        info.revert();
                    }
                });
            },
            // Clique em evento existente
            eventClick: function(info) {
                var eventProps = info.event.extendedProps;

                // Esconder todos os blocos
                $('#corpoModalOs, #corpoModalCompromisso, #corpoModalFinanceiro').hide();
                $('#acoesModalOs, #acoesModalCompromisso').hide();

                if (eventProps.tipo === 'compromisso') {
                    idCompromissoAtivo = eventProps.rawId;
                    $('#myModalLabel').html('<i class="bx bx-pin" style="color: #ff9204;"></i> Detalhes do Compromisso');
                    $('#compDetalheTitulo').text(eventProps.titulo);
                    $('#compDetalheData').text(eventProps.data_inicio);
                    $('#compDetalheUsuario').text(eventProps.usuario);
                    $('#compDetalheStatus').text(eventProps.status);
                    $('#compDetalheDescricao').text(eventProps.descricao || 'Sem observações.');
                    $('#corpoModalCompromisso').show();
                    $('#acoesModalCompromisso').show();
                } else if (eventProps.tipo === 'financeiro') {
                    $('#myModalLabel').html('<i class="bx bx-dollar-circle" style="color: #10b981;"></i> Vencimento Financeiro');
                    $('#finDetalheTipo').html(eventProps.tipoFin === 'Receita' ? '<span style="color: #10b981;">Conta a Receber</span>' : '<span style="color: #ef4444;">Conta a Pagar</span>');
                    $('#finDetalheCliente').text(eventProps.cliente_fornecedor);
                    $('#finDetalheVencimento').text(eventProps.vencimento);
                    $('#finDetalheValor').text(eventProps.valor).css('color', eventProps.tipoFin === 'Receita' ? '#10b981' : '#ef4444');
                    $('#finDetalheStatus').html(eventProps.statusFin === 'Baixado' ? '<span class="badge badge-success">Baixado</span>' : '<span class="badge badge-warning">Pendente</span>');
                    $('#finDetalheDescricao').text(eventProps.descricao || 'Sem descrição.');
                    $('#corpoModalFinanceiro').show();
                } else {
                    // OS padrão
                    $('#myModalLabel').text('Status OS Detalhada');
                    $('#modalId').html(eventProps.id);
                    $('#modalIdVisualizar').attr("href", "<?= base_url(); ?>index.php/os/visualizar/" + eventProps.id);
                    if (eventProps.editar) {
                        $('#modalIdEditar').show().attr("href", "<?= base_url(); ?>index.php/os/editar/" + eventProps.id);
                        $('#linkExcluir').show();
                        $('#modalIdExcluir').val(eventProps.id);
                    } else {
                        $('#modalIdEditar, #linkExcluir').hide();
                    }
                    $('#modalCliente').html(eventProps.cliente);
                    $('#modalDataInicial').html(eventProps.dataInicial);
                    $('#modalDataFinal').html(eventProps.dataFinal);
                    $('#modalGarantia').html(eventProps.garantia);
                    $('#modalStatus').html(eventProps.status);
                    $('#modalDescription').html(eventProps.description);
                    $('#modalDefeito').html(eventProps.defeito);
                    $('#modalObservacoes').html(eventProps.observacoes);
                    $('#modalSubtotal').html(eventProps.subtotal);
                    $('#modalDesconto').html(eventProps.desconto);
                    $('#modalTotal').html(eventProps.total);
                    $('#modalFaturado').html(eventProps.faturado);
                    $('#corpoModalOs').show();
                    $('#acoesModalOs').show();
                }

                $('#calendarModal').modal('show');
            },
        });

        srcCalendar.render();

        // Filtro tipo e status
        $('#filtroTipoAgenda').on('change', function() {
            var tipo = $(this).val();
            if (tipo === 'financeiro' || tipo === 'compromissos') {
                $('#wrapperFiltroStatus').hide();
            } else {
                $('#wrapperFiltroStatus').show();
            }
            srcCalendar.refetchEvents();
        });

        $('#statusOsGet').on('change', function() {
            srcCalendar.refetchEvents();
        });

        $('#btn-calendar').on('click', function() {
            srcCalendar.refetchEvents();
        });

        // Abrir modal de novo compromisso
        $('#btn-novo-compromisso').on('click', function() {
            var hoje = new Date().toISOString().slice(0, 10);
            $('#comp_data').val(hoje);
            $('#comp_titulo').val('');
            $('#comp_descricao').val('');
            $('#modalNovoCompromisso').modal('show');
        });

        $('#btnAcaoCriarCompromisso').on('click', function() {
            $('#modalAcaoDia').modal('hide');
            $('#comp_data').val(dataClicadaTemp);
            $('#comp_titulo').val('');
            $('#comp_descricao').val('');
            $('#modalNovoCompromisso').modal('show');
        });

        // Salvar compromisso via AJAX
        $('#formNovoCompromisso').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "<?= site_url('sistema/adicionarCompromissoAjax'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(resp) {
                    if (resp.success) {
                        $('#modalNovoCompromisso').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: resp.message,
                            timer: 2500,
                            showConfirmButton: false
                        });
                        srcCalendar.refetchEvents();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: resp.message || 'Não foi possível salvar.'
                        });
                    }
                }
            });
        });

        // Excluir compromisso
        $('#btnExcluirCompromisso').on('click', function() {
            if (!idCompromissoAtivo) return;

            Swal.fire({
                title: 'Excluir Compromisso?',
                text: 'Esta ação não pode ser desfeita.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?= site_url('sistema/excluirCompromissoAjax'); ?>",
                        type: 'POST',
                        dataType: 'json',
                        data: { id: idCompromissoAtivo },
                        success: function(resp) {
                            if (resp.success) {
                                $('#calendarModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Compromisso excluído!',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                srcCalendar.refetchEvents();
                            }
                        }
                    });
                }
            });
        });
    });
</script>
