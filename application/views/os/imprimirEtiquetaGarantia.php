<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Etiqueta e Selo de Garantia - OS #<?= sprintf('%04d', $result->idOs) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            color: #111;
            padding: 20px;
        }

        /* Toolbar Superior */
        .toolbar {
            max-width: 1050px;
            margin: 0 auto 20px auto;
            background: #fff;
            padding: 16px 22px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
        }

        .toolbar-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .toolbar label {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            margin: 0;
        }

        .toolbar select, .toolbar input {
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            margin: 0;
            height: 34px;
            background: #fff;
        }

        .btn-print {
            background: #ff9204;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-print:hover {
            background: #e07f00;
        }

        /* Container Principal */
        .print-viewport {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* MODO INDIVIDUAL (Térmica / Bobina) */
        .single-label-view {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .warranty-label {
            background: #fff;
            border: 1px dashed #777;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            padding: 2.5mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            position: relative;
        }

        /* MODO FOLHA A4 (Grade de Selos de Garantia) */
        .a4-sheet {
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            padding: 10mm 8mm;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            gap: 3mm 4mm;
            margin: 0 auto;
        }

        /* SELO ESTILO LACRE CASCA DE OVO / VOID (Layouts A-001 a A-014) */
        .seal-card {
            background: #fff;
            border: 1.2px solid #000;
            border-radius: 2px;
            box-sizing: border-box;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        /* Variantes de Tamanho do Selo na A4 */
        .seal-size-small {
            width: 32mm;
            height: 16mm;
            padding: 1mm;
        }
        .seal-size-medium {
            width: 40mm;
            height: 20mm;
            padding: 1.2mm;
        }
        .seal-size-large {
            width: 48mm;
            height: 24mm;
            padding: 1.5mm;
        }

        /* Componentes Internos do Selo */
        .seal-top {
            display: flex;
            border-bottom: 1px solid #000;
            padding-bottom: 0.8mm;
            margin-bottom: 0.8mm;
            align-items: center;
            justify-content: space-between;
        }

        .seal-logo-area {
            flex: 1;
            text-align: center;
            overflow: hidden;
            padding-right: 1mm;
        }

        .seal-logo-text {
            font-size: 8.5pt;
            font-weight: 900;
            color: #0b69a3;
            text-transform: uppercase;
            line-height: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .seal-phone-text {
            font-size: 6pt;
            font-weight: 700;
            color: #222;
            line-height: 1;
        }

        .seal-alert-box {
            border-left: 1px solid #000;
            padding-left: 1mm;
            text-align: center;
            font-size: 5.5pt;
            font-weight: 900;
            line-height: 1.1;
            color: #c00000;
            text-transform: uppercase;
        }

        .seal-os-tag {
            font-size: 6.5pt;
            font-weight: 900;
            background: #000;
            color: #fff;
            padding: 0 2px;
            border-radius: 1px;
            display: inline-block;
        }

        /* Grade de Meses (J F M A M J J A S O N D) */
        .month-grid {
            display: flex;
            width: 100%;
            border-top: 1px solid #000;
            border-left: 1px solid #000;
        }

        .month-cell {
            flex: 1;
            text-align: center;
            font-size: 5.5pt;
            font-weight: 800;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            line-height: 1.3;
        }

        .month-cell.active-mark {
            background: #ff9204;
            color: #fff;
            font-weight: 900;
        }

        /* Grade de Anos (24, 25, 26, 27, 28) */
        .year-grid {
            display: flex;
            flex-direction: column;
            border-left: 1px solid #000;
            min-width: 16px;
        }

        .year-cell {
            text-align: center;
            font-size: 5pt;
            font-weight: 800;
            border-bottom: 1px solid #000;
            line-height: 1.2;
            color: #c00000;
        }

        .year-cell.active-year {
            background: #000;
            color: #fff;
        }

        /* Grade de Dias (1 a 31) */
        .days-matrix {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            border-top: 0.8px solid #000;
            border-left: 0.8px solid #000;
            margin-bottom: 0.8mm;
        }

        .day-cell {
            font-size: 4.8pt;
            font-weight: 700;
            text-align: center;
            border-right: 0.8px solid #000;
            border-bottom: 0.8px solid #000;
            line-height: 1.1;
        }

        .day-cell.active-day {
            background: #000;
            color: #fff;
        }

        .warranty-choice-row {
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-size: 5.5pt;
            font-weight: 800;
            margin: 0.5mm 0;
            background: #f7f7f7;
            padding: 0.5mm 0;
            border: 0.8px solid #ddd;
        }

        .warranty-choice-item {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .warranty-checkbox {
            display: inline-block;
            width: 6px;
            height: 6px;
            border: 0.8px solid #000;
        }

        .warranty-checkbox.checked {
            background: #000;
        }

        /* Regras de Impressão */
        @media print {
            body {
                background: transparent;
                padding: 0;
                margin: 0;
            }

            .toolbar {
                display: none !important;
            }

            .print-viewport {
                margin: 0;
                padding: 0;
                display: block;
            }

            .warranty-label {
                border: none;
                box-shadow: none;
                margin: 0;
                page-break-inside: avoid;
            }

            .a4-sheet {
                box-shadow: none;
                padding: 8mm 6mm;
                margin: 0;
                page-break-after: always;
            }

            .seal-card {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <?php
        // Dados da OS e Emitente
        $diasGarantia = !empty($result->garantia) ? (int)$result->garantia : 90;
        $dataEntrada = !empty($result->dataInicial) ? date('d/m/Y', strtotime($result->dataInicial)) : '---';
        $dataSaida = !empty($result->dataFinal) ? date('d/m/Y', strtotime($result->dataFinal)) : date('d/m/Y');
        
        $baseDate = !empty($result->dataFinal) ? $result->dataFinal : date('Y-m-d');
        $vencimentoGarantia = ($diasGarantia > 0) ? date('d/m/Y', strtotime($baseDate . " + {$diasGarantia} days")) : 'Sem garantia';

        $diaAtual = (int)date('d', strtotime($baseDate));
        $mesAtual = (int)date('m', strtotime($baseDate));
        $anoAtual = (int)date('y', strtotime($baseDate));

        $nomeCliente = !empty($result->nomeCliente) ? $result->nomeCliente : 'Consumidor';
        $nomeEmpresa = !empty($emitente->nome) ? $emitente->nome : 'Amura OS';
        $telEmpresa = !empty($emitente->telefone) ? $emitente->telefone : '';
    ?>

    <div class="toolbar">
        <div class="toolbar-group">
            <label for="tipoImpressao"><i class="fa fa-print"></i> Tipo de Impressão:</label>
            <select id="tipoImpressao" onchange="alternarTipoImpressao(this.value)">
                <option value="a4" selected>Folha A4 (Grade de Múltiplos Selos / Lacres de Garantia)</option>
                <option value="thermal">Etiqueta Individual (Térmica / Bobina Única)</option>
            </select>
        </div>

        <!-- Opções para Folha A4 -->
        <div class="toolbar-group" id="opcoesA4">
            <label for="modeloA4">Modelo do Selo:</label>
            <select id="modeloA4" onchange="atualizarGradeA4()">
                <option value="A001" selected>A-001: Logo + Não Remova + Meses & Anos</option>
                <option value="A002">A-002: Logo + Grade de Dias (1-31) + Meses</option>
                <option value="A004">A-004: Logo + Prazos (3M/6M/12M) + Meses</option>
                <option value="os_detail">Etiqueta com Dados da OS (Cliente, Nº, Datas)</option>
            </select>

            <label for="tamanhoSelo">Tamanho:</label>
            <select id="tamanhoSelo" onchange="atualizarGradeA4()">
                <option value="small">Pequeno (32 x 16 mm - ~70 p/ folha)</option>
                <option value="medium" selected>Médio (40 x 20 mm - ~48 p/ folha)</option>
                <option value="large">Grande (48 x 24 mm - ~32 p/ folha)</option>
            </select>

            <label for="modoPreenchimento">Marcação:</label>
            <select id="modoPreenchimento" onchange="atualizarGradeA4()">
                <option value="branco" selected>Em branco (Para furar/marcar na bancada)</option>
                <option value="preenchido">Pré-marcar dados desta OS</option>
            </select>

            <label for="qtdEtiquetas">Quantidade:</label>
            <input type="number" id="qtdEtiquetas" value="48" min="1" max="120" style="width: 65px;" onchange="atualizarGradeA4()">
        </div>

        <!-- Opções para Térmica Individual -->
        <div class="toolbar-group" id="opcoesTermica" style="display: none;">
            <label for="formatoTermica">Formato:</label>
            <select id="formatoTermica" onchange="alterarFormatoTermica(this.value)">
                <option value="50x30">50 x 30 mm</option>
                <option value="60x40">60 x 40 mm</option>
                <option value="80x50">80 x 50 mm</option>
                <option value="100x50">100 x 50 mm</option>
                <option value="custom">Personalizado (mm)</option>
            </select>
            <div id="dimensoesCustom" style="display: none; align-items: center; gap: 5px;">
                <input type="number" id="customW" value="50" min="20" max="200" style="width: 55px;" placeholder="L" onchange="aplicarCustomTermica()">
                x
                <input type="number" id="customH" value="30" min="20" max="200" style="width: 55px;" placeholder="A" onchange="aplicarCustomTermica()">
            </div>
        </div>

        <div class="toolbar-group">
            <button type="button" class="btn-print" onclick="window.print()">
                <i class="fa fa-print"></i> Imprimir
            </button>
            <button type="button" class="btn btn-default" style="height: 34px;" onclick="window.close()">Fechar</button>
        </div>
    </div>

    <!-- VIEWPORT DE IMPRESSÃO -->
    <div class="print-viewport">
        <!-- VISTA FOLHA A4 -->
        <div class="a4-sheet" id="a4Container">
            <!-- As etiquetas são renderizadas aqui pelo JavaScript -->
        </div>

        <!-- VISTA TÉRMICA INDIVIDUAL -->
        <div class="single-label-view" id="thermalContainer" style="display: none;">
            <div class="warranty-label" id="singleThermalLabel" style="width: 50mm; height: 30mm;">
                <div style="border-bottom: 1px solid #111; padding-bottom: 1mm; margin-bottom: 1mm; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase;"><?= html_escape($nomeEmpresa) ?></span>
                    <span style="font-size: 11px; font-weight: 900; background: #000; color: #fff; padding: 1px 4px; border-radius: 2px;">OS #<?= sprintf('%04d', $result->idOs) ?></span>
                </div>
                <div style="font-size: 9px; line-height: 1.3;">
                    <div><strong>Cli:</strong> <?= html_escape($nomeCliente) ?></div>
                    <div style="display: flex; justify-content: space-between; margin-top: 1mm;">
                        <span><strong>Ent:</strong> <?= $dataEntrada ?></span>
                        <span><strong>Saída:</strong> <?= $dataSaida ?></span>
                    </div>
                    <div style="background: #eee; border: 1px solid #ccc; text-align: center; padding: 1mm; margin: 1.5mm 0; border-radius: 2px;">
                        <strong>GARANTIA: <?= $diasGarantia > 0 ? "{$diasGarantia} DIAS" : "S/ GARANTIA" ?></strong>
                        <div style="font-size: 8px;">Vencimento: <?= $vencimentoGarantia ?></div>
                    </div>
                </div>
                <div style="border-top: 1px dashed #888; text-align: center; font-size: 7px; font-weight: 700;">
                    LACRE DE GARANTIA - INVÁLIDO SE VIOLADO <?= $telEmpresa ? "| {$telEmpresa}" : "" ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const meses = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];
        const anos = [26, 27, 28];
        const osNumber = "<?= sprintf('%04d', $result->idOs) ?>";
        const empresa = "<?= html_escape($nomeEmpresa) ?>";
        const telefone = "<?= html_escape($telEmpresa) ?>";
        const cliente = "<?= html_escape($nomeCliente) ?>";
        const dataEntrada = "<?= $dataEntrada ?>";
        const dataSaida = "<?= $dataSaida ?>";
        const diasGarantia = <?= $diasGarantia ?>;
        const vencimento = "<?= $vencimentoGarantia ?>";
        const mesAtualIdx = <?= $mesAtual - 1 ?>;
        const anoAtualVal = <?= $anoAtual ?>;
        const diaAtualVal = <?= $diaAtual ?>;

        function gerarHtmlSelo(modelo, tamanhoClass, modoPreenchimento) {
            const preencher = (modoPreenchimento === 'preenchido');

            if (modelo === 'A001') {
                const mark1M = preencher && (diasGarantia <= 30) ? 'checked' : '';
                const mark3M = preencher && (diasGarantia > 30 && diasGarantia <= 90) ? 'checked' : '';
                const mark6M = preencher && (diasGarantia > 90) ? 'checked' : '';

                return `
                    <div class="seal-card ${tamanhoClass}">
                        <div class="seal-top">
                            <div class="seal-logo-area">
                                <div class="seal-logo-text">${empresa}</div>
                                <div class="seal-phone-text">${telefone}</div>
                            </div>
                            <div class="seal-alert-box">
                                NÃO REMOVA<br>SELO DE GARANTIA
                            </div>
                        </div>

                        <div class="warranty-choice-row">
                            <span class="seal-os-tag">OS #${osNumber}</span>
                            <span class="warranty-choice-item"><span class="warranty-checkbox ${mark1M}"></span> 1M</span>
                            <span class="warranty-choice-item"><span class="warranty-checkbox ${mark3M}"></span> 3M</span>
                            <span class="warranty-choice-item"><span class="warranty-checkbox ${mark6M}"></span> 6M</span>
                        </div>

                        <div style="display: flex;">
                            <div class="month-grid" style="flex: 1;">
                                ${meses.map((m, idx) => `<div class="month-cell ${preencher && idx === mesAtualIdx ? 'active-mark' : ''}">${m}</div>`).join('')}
                            </div>
                            <div class="year-grid">
                                ${anos.map(a => `<div class="year-cell ${preencher && a === anoAtualVal ? 'active-year' : ''}">${a}</div>`).join('')}
                            </div>
                        </div>
                    </div>
                `;
            } else if (modelo === 'A002') {
                // Modelo com Grid de 31 Dias + Meses
                let diasHtml = '';
                for (let d = 1; d <= 31; d++) {
                    const isDiaAtivo = preencher && (d === diaAtualVal) ? 'active-day' : '';
                    diasHtml += `<div class="day-cell ${isDiaAtivo}">${d}</div>`;
                }
                return `
                    <div class="seal-card ${tamanhoClass}">
                        <div class="seal-top" style="margin-bottom: 0.5mm; padding-bottom: 0.5mm;">
                            <div class="seal-logo-area" style="text-align: left;">
                                <div class="seal-logo-text">${empresa}</div>
                            </div>
                            <span class="seal-os-tag">OS #${osNumber}</span>
                        </div>
                        <div class="days-matrix">
                            ${diasHtml}
                        </div>
                        <div style="display: flex;">
                            <div class="month-grid" style="flex: 1;">
                                ${meses.map((m, idx) => `<div class="month-cell ${preencher && idx === mesAtualIdx ? 'active-mark' : ''}">${m}</div>`).join('')}
                            </div>
                            <div class="year-grid">
                                ${anos.map(a => `<div class="year-cell ${preencher && a === anoAtualVal ? 'active-year' : ''}">${a}</div>`).join('')}
                            </div>
                        </div>
                    </div>
                `;
            } else if (modelo === 'A004') {
                const mark3M = preencher && (diasGarantia <= 90) ? 'checked' : '';
                const mark6M = preencher && (diasGarantia > 90 && diasGarantia <= 180) ? 'checked' : '';
                const mark12M = preencher && (diasGarantia > 180 && diasGarantia <= 365) ? 'checked' : '';

                return `
                    <div class="seal-card ${tamanhoClass}">
                        <div class="seal-top">
                            <div class="seal-logo-area">
                                <div class="seal-logo-text">${empresa}</div>
                                <div class="seal-phone-text">OS #${osNumber} | ${telefone}</div>
                            </div>
                        </div>
                        <div class="warranty-choice-row">
                            <span class="warranty-choice-item"><span class="warranty-checkbox ${mark3M}"></span> 3M</span>
                            <span class="warranty-choice-item"><span class="warranty-checkbox ${mark6M}"></span> 6M</span>
                            <span class="warranty-choice-item"><span class="warranty-checkbox ${mark12M}"></span> 12M</span>
                        </div>
                        <div style="display: flex;">
                            <div class="month-grid" style="flex: 1;">
                                ${[1,2,3,4,5,6,7,8,9,10,11,12].map(num => `<div class="month-cell ${preencher && num === (mesAtualIdx + 1) ? 'active-mark' : ''}">${num}</div>`).join('')}
                            </div>
                            <div class="year-grid">
                                ${anos.map(a => `<div class="year-cell ${preencher && a === anoAtualVal ? 'active-year' : ''}">${a}</div>`).join('')}
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Modelo Detalhado da OS
                return `
                    <div class="seal-card ${tamanhoClass}" style="padding: 1.5mm; font-size: 6.5pt; line-height: 1.2;">
                        <div style="display: flex; justify-content: space-between; border-bottom: 0.8px solid #000; padding-bottom: 1px; margin-bottom: 1px;">
                            <strong style="color: #0b69a3; text-transform: uppercase;">${empresa}</strong>
                            <span class="seal-os-tag">#${osNumber}</span>
                        </div>
                        <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong>Cli:</strong> ${cliente}</div>
                        <div style="display: flex; justify-content: space-between;">
                            <span><strong>Ent:</strong> ${dataEntrada}</span>
                            <span><strong>Garantia:</strong> ${diasGarantia}d</span>
                        </div>
                        <div style="background: #000; color: #fff; text-align: center; font-size: 5.5pt; font-weight: 800; margin-top: 1px;">
                            VENCIMENTO: ${vencimento}
                        </div>
                    </div>
                `;
            }
        }

        function atualizarGradeA4() {
            const container = document.getElementById('a4Container');
            const modelo = document.getElementById('modeloA4').value;
            const tamanho = document.getElementById('tamanhoSelo').value;
            const modoPreenchimento = document.getElementById('modoPreenchimento') ? document.getElementById('modoPreenchimento').value : 'branco';
            const qtd = parseInt(document.getElementById('qtdEtiquetas').value, 10) || 48;

            const tamanhoClass = tamanho === 'small' ? 'seal-size-small' : (tamanho === 'large' ? 'seal-size-large' : 'seal-size-medium');

            let html = '';
            for (let i = 0; i < qtd; i++) {
                html += gerarHtmlSelo(modelo, tamanhoClass, modoPreenchimento);
            }
            container.innerHTML = html;

            // Ajustar regra @page para folha A4
            let styleTag = document.getElementById('dynamicPageStyle');
            if (!styleTag) {
                styleTag = document.createElement('style');
                styleTag.id = 'dynamicPageStyle';
                document.head.appendChild(styleTag);
            }
            styleTag.innerHTML = `@page { size: A4 portrait; margin: 5mm; }`;
        }

        function alternarTipoImpressao(tipo) {
            const a4Container = document.getElementById('a4Container');
            const thermalContainer = document.getElementById('thermalContainer');
            const opcoesA4 = document.getElementById('opcoesA4');
            const opcoesTermica = document.getElementById('opcoesTermica');

            if (tipo === 'a4') {
                a4Container.style.display = 'flex';
                thermalContainer.style.display = 'none';
                opcoesA4.style.display = 'flex';
                opcoesTermica.style.display = 'none';
                atualizarGradeA4();
            } else {
                a4Container.style.display = 'none';
                thermalContainer.style.display = 'flex';
                opcoesA4.style.display = 'none';
                opcoesTermica.style.display = 'flex';
                alterarFormatoTermica(document.getElementById('formatoTermica').value);
            }
        }

        function alterarFormatoTermica(formato) {
            const label = document.getElementById('singleThermalLabel');
            const dimensoes = document.getElementById('dimensoesCustom');

            const sizes = {
                '50x30': { w: '50mm', h: '30mm' },
                '60x40': { w: '60mm', h: '40mm' },
                '80x50': { w: '80mm', h: '50mm' },
                '100x50': { w: '100mm', h: '50mm' }
            };

            if (formato === 'custom') {
                dimensoes.style.display = 'inline-flex';
                aplicarCustomTermica();
            } else {
                dimensoes.style.display = 'none';
                const s = sizes[formato] || sizes['50x30'];
                label.style.width = s.w;
                label.style.height = s.h;

                let styleTag = document.getElementById('dynamicPageStyle');
                if (!styleTag) {
                    styleTag = document.createElement('style');
                    styleTag.id = 'dynamicPageStyle';
                    document.head.appendChild(styleTag);
                }
                styleTag.innerHTML = `@page { size: ${s.w} ${s.h}; margin: 0; }`;
            }
        }

        function aplicarCustomTermica() {
            const w = document.getElementById('customW').value || 50;
            const h = document.getElementById('customH').value || 30;
            const label = document.getElementById('singleThermalLabel');
            label.style.width = `${w}mm`;
            label.style.height = `${h}mm`;

            let styleTag = document.getElementById('dynamicPageStyle');
            if (!styleTag) {
                styleTag = document.createElement('style');
                styleTag.id = 'dynamicPageStyle';
                document.head.appendChild(styleTag);
            }
            styleTag.innerHTML = `@page { size: ${w}mm ${h}mm; margin: 0; }`;
        }

        // Inicializar com Folha A4 por padrão
        window.onload = function() {
            alternarTipoImpressao('a4');
        };
    </script>
</body>
</html>
