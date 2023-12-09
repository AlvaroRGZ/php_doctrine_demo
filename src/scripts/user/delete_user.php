<?php

/**
 * src/delete_user.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

// Obtener argumentos de la línea de comandos
$options = getopt("n:");

if (empty($options['n'])) {
    echo "Usage: php delete_user.php -n <username>" . PHP_EOL;
    exit(1);
}

$username = $options['n'];

$entityManager = DoctrineConnector::getEntityManager();

$userAdapter = new UserAdapter();

try {
    $userAdapter->deleteUser($username);
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
