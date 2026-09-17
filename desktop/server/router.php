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

// Blindagem de Ambiente Amura OS Desktop:
// Assegurar que o servidor PHP interno utilize a instância local do MariaDB gerenciada pelo app
$_ENV['DB_HOSTNAME'] = getenv('DB_HOSTNAME') ?: '127.0.0.1';
$_ENV['DB_PORT'] = getenv('DB_PORT') ?: '3307';
$_ENV['DB_USERNAME'] = getenv('DB_USERNAME') ?: 'root';
$_ENV['DB_PASSWORD'] = (getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== '') ? getenv('DB_PASSWORD') : '';
$_ENV['DB_DATABASE'] = getenv('DB_DATABASE') ?: 'amura_os';
$_ENV['DB_DRIVER'] = getenv('DB_DRIVER') ?: 'mysqli';
$_ENV['APP_BASEURL'] = getenv('APP_BASEURL') ?: 'http://127.0.0.1:8002/';

$_SERVER['DB_HOSTNAME'] = $_ENV['DB_HOSTNAME'];
$_SERVER['DB_PORT'] = $_ENV['DB_PORT'];
$_SERVER['DB_USERNAME'] = $_ENV['DB_USERNAME'];
$_SERVER['DB_PASSWORD'] = $_ENV['DB_PASSWORD'];
$_SERVER['DB_DATABASE'] = $_ENV['DB_DATABASE'];
$_SERVER['DB_DRIVER'] = $_ENV['DB_DRIVER'];
$_SERVER['APP_BASEURL'] = $_ENV['APP_BASEURL'];

// Configurar variáveis de ambiente do CodeIgniter
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . DIRECTORY_SEPARATOR . 'index.php';
$_SERVER['DOCUMENT_ROOT'] = $root;

// Carregar o CodeIgniter
chdir($root);
require $root . DIRECTORY_SEPARATOR . 'index.php';

