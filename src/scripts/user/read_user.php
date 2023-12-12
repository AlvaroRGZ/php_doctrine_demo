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
use MiW\Results\Utility\JSONResponse;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

// Obtener argumentos de la línea de comandos
$options = getopt("n:i:", ["json"]);

if (empty($options['n']) && empty($options['i'])) {
    echo "Usage: php read_user.php [-n <username>] | [-i <id>]" . PHP_EOL;
    exit(1);
}

$user = null;
$userAdapter = new UserAdapter();

if (!empty($options['i'])) {
    $id = $options['i'];
    $user = $userAdapter->readUserById($id);
} else {
    $username = $options['n'];
    $user = $userAdapter->readUserByUsername($username);
}

if ($user) {
    echo json_encode($user->jsonSerialize()) . PHP_EOL;
} else {
    if (isset($options["json"])) {
        echo new JSONResponse("error", "User not found") . PHP_EOL;
    } else {
        echo "User not found" . PHP_EOL;
    }
}