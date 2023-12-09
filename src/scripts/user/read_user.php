<?php

/**
 * src/read_user.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;
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

$userAdapter = new UserAdapter();

try {
    $user = $userAdapter->readUserByUsername($username);

    if ($user) {
        echo json_encode($user->jsonSerialize()) . PHP_EOL;
    } else {
        echo "User " . $username . " not found" . PHP_EOL;
    }
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
