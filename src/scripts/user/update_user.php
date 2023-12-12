<?php

/**
 * src/update_user.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 3) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\JSONResponse;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 3));

// Obtener argumentos de la línea de comandos
$options = getopt("o:n:e:p:b:a:", ["json"]);

if (empty($options['o']) || empty($options['n']) || empty($options['e']) ||
    empty($options['p']) || empty($options['b']) || empty($options['a'])) {
    echo "Usage: php update_user.php -o <oldusername> -n <username> -e <email> -p <password> -b <enabled> -a <admin>" . PHP_EOL;
    exit(1);
}

$oldusername = $options['o'];
$username = $options['n'];
$email = $options['e'];
$password = $options['p'];
$enabled = $options['b'] == "1";
$isAdmin = $options['a'] == "1";

$userAdapter = new UserAdapter();

try {
    if ($userAdapter->updateUser($oldusername, $username, $email, $password, $enabled, $isAdmin)) {
        $message = "Updated user " . $oldusername . " now: " . $username;
        if (isset($options["json"])) {
            echo new JSONResponse("success", $message) . PHP_EOL;
        } else {
            echo $message . PHP_EOL;
        }
    } else {
        $message = "User " . $oldusername . " not found";
        if (isset($options["json"])) {
            echo new JSONResponse("error", $message) . PHP_EOL;
        } else {
            echo $message . PHP_EOL;
        }
    }
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
