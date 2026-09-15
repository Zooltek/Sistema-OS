<?php
/**
 * Router para o Servidor Embutido do PHP (PHP Built-in Web Server)
 * Amura OS - Desktop Portable
 */

$root = dirname(dirname(__DIR__));
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);

$filePath = $root . str_replace('/', DIRECTORY_SEPARATOR, $uri);

// Se for um arquivo estático existente (css, js, imagens, fontes, uploads, anexos), servir diretamente
if ($uri !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

// Descartar rapidamente arquivos estáticos ausentes (como .map ou favicon) sem carregar o framework
if (preg_match('/\.(?:map|ico|png|jpg|jpeg|gif|css|js|woff|woff2|ttf|svg)$/i', $uri)) {
    http_response_code(404);
    exit;
}

// BLINDAGEM CONTRA TRAVAMENTOS (Single-Threaded):
// Forçar fechamento imediato do socket HTTP após a resposta.
// Isso impede que o Chromium/Electron retenha a conexão em Keep-Alive,
// liberando o processo PHP imediatamente para atender a próxima tela/requisição.
header('Connection: close');

// Configurar variáveis de ambiente do CodeIgniter
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . DIRECTORY_SEPARATOR . 'index.php';
$_SERVER['DOCUMENT_ROOT'] = $root;

// Carregar o CodeIgniter
chdir($root);
require $root . DIRECTORY_SEPARATOR . 'index.php';

