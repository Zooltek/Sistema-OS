<?php
/**
 * Script CLI de Backup do Banco de Dados MariaDB para Amura OS
 * Gera um dump .sql completo e compatível
 */

if (php_sapi_name() !== 'cli') {
    die('Acesso negado.');
}

$outputFile = $argv[1] ?? null;

if (!$outputFile) {
    fwrite(STDERR, "Erro: Arquivo de saída não especificado.\n");
    exit(1);
}

$host = getenv('DB_HOSTNAME') ?: '127.0.0.1';
$port = (int)(getenv('DB_PORT') ?: 3307);
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$dbName = getenv('DB_DATABASE') ?: 'amura_os';

try {
    $mysqli = new mysqli($host, $user, $pass, $dbName, $port);
    if ($mysqli->connect_error) {
        throw new Exception("Falha de conexão: " . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4');

    $handle = fopen($outputFile, 'w');
    if (!$handle) {
        throw new Exception("Não foi possível criar o arquivo: $outputFile");
    }

    $header = "-- ========================================================\n"
            . "-- Amura OS - Backup de Banco de Dados\n"
            . "-- Data/Hora: " . date('Y-m-d H:i:s') . "\n"
            . "-- Servidor: MariaDB / MySQL\n"
            . "-- ========================================================\n\n"
            . "SET NAMES utf8mb4;\n"
            . "SET FOREIGN_KEY_CHECKS = 0;\n"
            . "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n\n";
    fwrite($handle, $header);

    // Listar tabelas
    $tablesResult = $mysqli->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
    $tables = [];
    while ($row = $tablesResult->fetch_row()) {
        $tables[] = $row[0];
    }

    foreach ($tables as $table) {
        // Obter CREATE TABLE
        $createRes = $mysqli->query("SHOW CREATE TABLE `{$table}`");
        $createRow = $createRes->fetch_row();
        $createSql = $createRow[1] ?? '';

        fwrite($handle, "-- --------------------------------------------------------\n");
        fwrite($handle, "-- Estrutura da tabela `{$table}`\n");
        fwrite($handle, "-- --------------------------------------------------------\n");
        fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
        fwrite($handle, $createSql . ";\n\n");

        // Obter Dados
        $dataRes = $mysqli->query("SELECT * FROM `{$table}`");
        $numRows = $dataRes->num_rows;
        if ($numRows > 0) {
            fwrite($handle, "-- Extraindo dados da tabela `{$table}` ({$numRows} registros)\n");
            $fieldsCount = $dataRes->field_count;

            $batchSize = 200;
            $currentBatch = 0;
            $valuesList = [];

            while ($row = $dataRes->fetch_row()) {
                $escapedValues = [];
                for ($i = 0; $i < $fieldsCount; $i++) {
                    if ($row[$i] === null) {
                        $escapedValues[] = 'NULL';
                    } else {
                        $escapedValues[] = "'" . $mysqli->real_escape_string($row[$i]) . "'";
                    }
                }
                $valuesList[] = "(" . implode(", ", $escapedValues) . ")";
                $currentBatch++;

                if ($currentBatch >= $batchSize) {
                    fwrite($handle, "INSERT INTO `{$table}` VALUES \n" . implode(",\n", $valuesList) . ";\n");
                    $valuesList = [];
                    $currentBatch = 0;
                }
            }

            if (!empty($valuesList)) {
                fwrite($handle, "INSERT INTO `{$table}` VALUES \n" . implode(",\n", $valuesList) . ";\n");
            }
            fwrite($handle, "\n");
        }
    }

    $footer = "SET FOREIGN_KEY_CHECKS = 1;\n"
            . "-- Fim do Backup Amura OS\n";
    fwrite($handle, $footer);
    fclose($handle);

    $mysqli->close();
    echo "SUCCESS\n";
    exit(0);

} catch (Exception $e) {
    fwrite(STDERR, "ERRO: " . $e->getMessage() . "\n");
    if (isset($handle) && is_resource($handle)) {
        fclose($handle);
    }
    exit(1);
}
