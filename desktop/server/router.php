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

// Configurar variáveis de ambiente do CodeIgniter
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . DIRECTORY_SEPARATOR . 'index.php';
$_SERVER['DOCUMENT_ROOT'] = $root;

// Carregar o CodeIgniter
chdir($root);
require $root . DIRECTORY_SEPARATOR . 'index.php';
