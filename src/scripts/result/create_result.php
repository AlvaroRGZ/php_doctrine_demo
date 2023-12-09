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
$options = getopt("n:r:");

if (empty($options['n']) || empty($options['r'])) {
    echo "Usage: php create_result_command.php -n <username> -r <result>" . PHP_EOL;
    exit(1);
}

$username = $options['n'];
$resultValue = $options['r'];

$resultAdapter = new ResultAdapter();

try {
    if ($resultAdapter->createResultFromScratch((int)$resultValue, $username)) {
        echo 'Created Result: ' . $username . " points: " . $resultValue . PHP_EOL;
    }

} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}