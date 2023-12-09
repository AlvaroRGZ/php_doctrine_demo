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
$options = getopt("n:");

if (empty($options['n'])) {
    echo "Usage: php read_user.php -n <username>" . PHP_EOL;
    exit(1);
}

$username = $options['n'];

$resultAdapter = new ResultAdapter();

try {
    $result = $resultAdapter->readResultByResultname($username);

    if ($result) {
        echo json_encode($result->jsonSerialize()) . PHP_EOL;
    } else {
        echo "Result " . $username . " not found" . PHP_EOL;
    }
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}