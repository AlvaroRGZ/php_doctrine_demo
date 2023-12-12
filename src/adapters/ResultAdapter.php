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

use DateTime;
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;
use Throwable;

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

    public function deleteResult(string $resultname): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $resultname]);

        if (!$user) {
            return false;
        }

        $resultRepository = $entityManager->getRepository(Result::class);
        $result = $resultRepository->findOneBy(['user' => $user->getId()]);

        if ($result) {
            try {
                $entityManager->remove($result);
                $entityManager->flush();
                return true;
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
                return true;
            }
        } else {
            return false;
        }
    }


    public function deleteResultById(int $resultId)
    {
        $entityManager = DoctrineConnector::getEntityManager();
        $resultRepository = $entityManager->getRepository(Result::class);
        $result = $resultRepository->findOneBy(['id' => $resultId]);

        if ($result) {
            try {
                $entityManager->remove($result);
                $entityManager->flush();
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
                return true;
            }
            return true;
        } else {
            return false;
        }
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

    public function readResultById(int $id): Result | null {
        $entityManager = DoctrineConnector::getEntityManager();
        $resultRepository = $entityManager->getRepository(Result::class);
        $result = $resultRepository->findOneBy(['id' => $id]);
        if ($result) {
            return $result;
        }
        return null;
    }

    public function updateResult(int $result, string $oldUsername, string $newUsername): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $newuser = $userRepository->findOneBy(['username' => $newUsername]);

        if (!$newuser) {
            echo "New user " . $newUsername . " not found" . PHP_EOL;
            return false;
        }

        $olduser = $userRepository->findOneBy(['username' => $oldUsername]);

        if (!$olduser) {
            echo "Old user " . $oldUsername . " not found" . PHP_EOL;
            return false;
        }

        $resultRepository = $entityManager->getRepository(Result::class);
        $updatingresult = $resultRepository->findOneBy(['user' => $olduser]);

        if ($updatingresult) {
            try {
                $updatingresult->setResult($result);
                $updatingresult->setTime(new DateTime());
                $updatingresult->setUser($newuser);

                $entityManager->flush();
                return true;
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
                return false;
            }
        }

        return false;
    }
}