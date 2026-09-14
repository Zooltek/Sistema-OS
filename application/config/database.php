<?php

defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = true;
$db['default'] = [
    'dsn' => $_ENV['DB_DSN'] ?? getenv('DB_DSN') ?: '',
    'hostname' => $_ENV['DB_HOSTNAME'] ?? getenv('DB_HOSTNAME') ?: '127.0.0.1',
    'port' => (int)($_ENV['DB_PORT'] ?? getenv('DB_PORT') ?: 3306),
    'username' => $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?: 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: '',
    'database' => $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?: 'amura_os',
    'dbdriver' => $_ENV['DB_DRIVER'] ?? getenv('DB_DRIVER') ?: 'mysqli',
    'dbprefix' => $_ENV['DB_PREFIX'] ?? getenv('DB_PREFIX') ?: '',
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
