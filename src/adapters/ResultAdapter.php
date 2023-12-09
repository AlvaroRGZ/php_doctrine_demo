<?php

/**
 * adapters/ResultAdapter.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Adapters;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 2));

class ResultAdapter {
    public function __construct(){}

    public function createResultFromScratch(int $result, string $username): bool {
        $entityManager = DoctrineConnector::getEntityManager();

        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);
        if (!$user) {
            echo "Error: User not found with username $username." . PHP_EOL;
            return false;
        }

        $result = new Result($result, $user);
        try {
            $entityManager->persist($result);
            $entityManager->flush();
            // echo 'Created Result ' . $username . ' with ID #' . $result->getId() . PHP_EOL;
        } catch (Throwable $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
        return true;
    }

    public function createResult(Result $result): void {
        $entityManager = DoctrineConnector::getEntityManager();
        try {
            $entityManager->persist($result);
            $entityManager->flush();
            echo 'Created Result ' . $result->getResultname() . ' with ID #' . $result->getId() . PHP_EOL;
        } catch (Throwable $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    public function deleteResult(string $resultname): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        $resultRepository = $entityManager->getRepository(Result::class);
        $result = $resultRepository->findOneBy(['username' => $resultname]);

        if ($result) {
            try {
                $entityManager->remove($result);
                $entityManager->flush();
                echo 'Deleted Result ' . $resultname . PHP_EOL;
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
            return true;
        } else {
            return false;
        }
    }

    public function existsResultByResultname(string $resultname): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        $resultRepository = $entityManager->getRepository(Result::class);

        if ($resultRepository->findOneBy(['username' => $resultname])) {
            return true;
        }
        return false;
    }

    public function readResultByResultname(string $resultname): Result | null {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $resultname]);

        if (!$user) {
            return null;
        }

        $resultRepository = $entityManager->getRepository(Result::class);
        $result = $resultRepository->findOneBy(['user' => $user->getId()]);
        if ($result) {
            return $result;
        }
        return null;
    }

    public function updateResult(string $resultname, string $newResultname, string $newEmail, string $newPassword, bool $enabled, bool $isAdmin) {
        $entityManager = DoctrineConnector::getEntityManager();

        $resultRepository = $entityManager->getRepository(Result::class);
        $result = $resultRepository->findOneBy(['username' => $resultname]);

        if ($result) {
            try {
                $result->setResultname($newResultname);
                $result->setEmail($newEmail);
                $result->setEnabled($enabled);
                $result->setIsAdmin($isAdmin);
                $result->setPassword($newPassword);

                $entityManager->flush();
                return true;
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }

        return false;
    }
}