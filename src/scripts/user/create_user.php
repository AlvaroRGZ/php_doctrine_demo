<?php

/**
 * src/create_user.php
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
$options = getopt("n:e:p:", ["json"]);

if (empty($options['n']) || empty($options['e']) || empty($options['p'])) {
    echo "Usage: php create_user_command_parser.php -n <username> -e <email> -p <password>" . PHP_EOL;
    exit(1);
}

$username = $options['n'];
$email = $options['e'];
$password = $options['p'];
$entityManager = DoctrineConnector::getEntityManager();

$user = new User();
$user->setUsername($username);
$user->setEmail($email);
$user->setPassword($password);

$userAdapter = new UserAdapter();

try {
    if ($userAdapter->createUser($user)) {
        $message = 'Created User ' . $user->getUsername() . ' with ID #' . $user->getId();
        if (isset($options["json"])) {
            echo new JSONResponse("success", $message) . PHP_EOL;
        } else {
            echo $message . PHP_EOL;
        }
    } else {
    $message = 'Failed while creating User ' . $user->getUsername();
    if (isset($options["json"])) {
        echo new JSONResponse("error", $message) . PHP_EOL;
    } else {
        echo $message . PHP_EOL;
    }
}
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
