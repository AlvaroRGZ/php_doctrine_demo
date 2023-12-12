<?php

/**
 * src/delete_result.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Adapters\ResultAdapter;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\JSONResponse;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

// Obtener argumentos de la línea de comandos
$options = getopt("n:", ["json"]);

if (empty($options['n'])) {
    echo "Usage: php delete_result.php -n <username>" . PHP_EOL;
    exit(1);
}

$username = $options['n'];

$entityManager = DoctrineConnector::getEntityManager();

$resultAdapter = new ResultAdapter();

try {
    if ($resultAdapter->deleteResult($username)) {
        $message = "Deleted last " . $username . " result" . PHP_EOL;
        if (isset($options["json"])) {
            echo new JSONResponse("success", $message) . PHP_EOL;
        } else {
            echo $message . PHP_EOL;
        }
    } else {
        $message = "Failed to delete last " . $username . " result" . PHP_EOL;
        if (isset($options["json"])) {
            echo new JSONResponse("error", $message) . PHP_EOL;
        } else {
            echo $message . PHP_EOL;
        }
    }

} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
