<?php

/**
 * src/create_result_command.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\adapters\ResultAdapter;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

// Obtener argumentos de la línea de comandos
$options = getopt("n:i:");

if (empty($options['n']) && empty($options['i'])) {
    echo "Usage: php read_result.php [-n <username>] | [-i <id>]" . PHP_EOL;
    exit(1);
}

$result = null;
$resultAdapter = new ResultAdapter();

if (!empty($options['i'])) {
    $id = $options['i'];
    $result = $resultAdapter->readResultById($id);
} else {
    $username = $options['n'];
    $result = $resultAdapter->readResultByResultname($username);
}

if ($result) {
    echo json_encode($result->jsonSerialize()) . PHP_EOL;
} else {
    echo "Result not found" . PHP_EOL;
}