<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once __DIR__ . '/../vendor/autoload.php';

function pdf_create($html, $filename, $stream = true, $landscape = false)
{
    @ini_set('memory_limit', '512M');
    @set_time_limit(180);

    $tempDir = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
    if (! is_dir($tempDir)) {
        @mkdir($tempDir, 0777, true);
    }

    // Normalizar caminhos locais com barras normais para o mPDF
    $fcpathNormalized = str_replace('\\', '/', FCPATH);

    // BLINDAGEM CONTRA DEADLOCK EM SERVIDOR PHP EMBUTIDO:
    // O PHP CLI Server é mono-processo. Se o mPDF tentar carregar CSS ou imagens via HTTP (ex: http://localhost:8002/assets/...),
    // ele trava o servidor indefinidamente esperando resposta de si mesmo.
    // Reescrevemos todas as referências para os caminhos locais do disco:
    $html = preg_replace_callback('/(href|src)=["\'](https?:\/\/[^\/"\']+(?::\d+)?\/[^\'"\']*)["\']/i', function ($matches) use ($fcpathNormalized) {
        $attr = $matches[1];
        $url = $matches[2];
        $parsed = parse_url($url);
        $path = isset($parsed['path']) ? ltrim($parsed['path'], '/') : '';

        // Se for um recurso da pasta assets, mapear direto para o arquivo físico no disco
        if (preg_match('/^assets\//i', $path)) {
            $localFile = $fcpathNormalized . $path;
            if (file_exists($localFile)) {
                return $attr . '="' . $localFile . '"';
            }
        }

        // Se for arquivo inexistente (como blue.css), anular para evitar requisições 404
        return $attr . '=""';
    }, $html);

    // Remover tags <link> inválidas ou sem href resultante
    $html = preg_replace('/<link[^>]+href=["\']["\'][^>]*>/i', '', $html);
    $html = preg_replace('/<link[^>]+blue\.css[^>]*>/i', '', $html);

    $config = [
        'mode' => 'utf-8',
        'format' => $landscape ? 'A4-L' : 'A4',
        'tempDir' => $tempDir,
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
    ];

    $mpdf = new \Mpdf\Mpdf($config);
    $mpdf->showImageErrors = false;
    $mpdf->WriteHTML($html);

    // Sanitizar nome do arquivo (remover barras como as de date('d/m/y'), dois-pontos, etc.)
    $safeFilename = preg_replace('/[\/\\\\?%*:|"<>]+/', '_', $filename);

    if ($stream) {
        // Limpar qualquer buffer residual para não corromper o stream binário do PDF
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $mpdf->Output($safeFilename . '.pdf', 'I');
    } else {
        $destPath = $tempDir . $safeFilename . '.pdf';
        $mpdf->Output($destPath, 'F');

        return $destPath;
    }
}
