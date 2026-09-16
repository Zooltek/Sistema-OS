<?php

defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = true;
$db['default'] = [
    'dsn' => getenv('DB_DSN') ?: ($_ENV['DB_DSN'] ?? ''),
    'hostname' => getenv('DB_HOSTNAME') ?: ($_ENV['DB_HOSTNAME'] ?? '127.0.0.1'),
    'port' => (int)(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? 3306)),
    'username' => getenv('DB_USERNAME') ?: ($_ENV['DB_USERNAME'] ?? 'root'),
    'password' => (getenv('DB_PASSWORD') !== false && getenv('DB_PASSWORD') !== null) ? getenv('DB_PASSWORD') : ($_ENV['DB_PASSWORD'] ?? ''),
    'database' => getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? 'amura_os'),
    'dbdriver' => getenv('DB_DRIVER') ?: ($_ENV['DB_DRIVER'] ?? 'mysqli'),
    'dbprefix' => getenv('DB_PREFIX') ?: ($_ENV['DB_PREFIX'] ?? ''),
    'pconnect' => false,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => $_ENV['DB_CHARSET'] ?? getenv('DB_CHARSET') ?: 'utf8mb4',
    'dbcollat' => $_ENV['DB_COLLATION'] ?? getenv('DB_COLLATION') ?: 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt' => false,
    'compress' => false,
    'stricton' => false,
    'failover' => [],
    'save_queries' => true,
];
