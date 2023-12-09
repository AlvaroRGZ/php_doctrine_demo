<?php

/**
 * src/update_result.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Adapters\ResultAdapter;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

// Obtener argumentos de la línea de comandos
$options = getopt("o:n:r:");

if (empty($options['o']) || empty($options['n']) || empty($options['r'])) {
    echo "Usage: php update_result.php -o <oldusername> -n <username> -e <result>" . PHP_EOL;
    exit(1);
}

$oldusername = $options['o'];
$newusername = $options['n'];
$result = (int)$options['r'];

$resultAdapter = new ResultAdapter();

try {
    if ($resultAdapter->updateResult($result, $oldusername, $newusername, )) {
        echo "Updated user " . $oldusername . " now: " . $newusername . " with " . $result . PHP_EOL;
    } else {
        echo "User " . $oldusername . " not found" . PHP_EOL;
    }
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
