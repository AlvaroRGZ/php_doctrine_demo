<?php

/**
 * src/create_result_command.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 2));

// Obtener argumentos de la línea de comandos
$options = getopt("n:r:");

if (empty($options['n']) || empty($options['r'])) {
    echo "Usage: php create_result_command.php -n <username> -r <result>" . PHP_EOL;
    exit(1);
}

$username = $options['n'];
$resultValue = $options['r'];

$entityManager = DoctrineConnector::getEntityManager();

// Obtener el usuario por su nombre de usuario
$userRepository = $entityManager->getRepository(User::class);
$user = $userRepository->findOneBy(['username' => $username]);

if (!$user) {
    echo "Error: User not found with username $username." . PHP_EOL;
    exit(1);
}

$result = new Result((int) $resultValue, $user);

try {
    $entityManager->persist($result);
    $entityManager->flush();
    echo 'Created Result with ID #' . $result->getId() . PHP_EOL;
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}