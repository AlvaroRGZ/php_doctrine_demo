<?php

/**
 * adapters/UserAdapter.php
 *
 * @category Utils
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Adapters;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;
use Throwable;

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 2));

class UserAdapter {
    public function __construct(){}

    public function createUserFromScratch(string $username, string $email, string $password): bool {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        $entityManager = DoctrineConnector::getEntityManager();
        try {
            $entityManager->persist($user);
            $entityManager->flush();
            echo 'Created User ' . $user->getUsername() . ' with ID #' . $user->getId() . PHP_EOL;
        } catch (Throwable $exception) {
            echo $exception->getMessage() . PHP_EOL;
            return false;
        }
        return true;
    }

    public function createUser(User $user): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        try {
            $entityManager->persist($user);
            $entityManager->flush();
            return true;
        } catch (Throwable $exception) {
            // echo $exception->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function deleteUser(string $username): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if ($user) {
            try {
                $entityManager->remove($user);
                $entityManager->flush();
            } catch (Throwable $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
            return true;
        } else {
            return false;
        }
    }

    public function existsUserByUsername(string $username): bool {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);

        if ($userRepository->findOneBy(['username' => $username])) {
            return true;
        }
        return false;
    }

    public function readUserByUsername(string $username): User | null {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($user) {
            return $user;
        }
        return null;
    }


    public function readUserById(int $id)
    {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['id' => $id]);
        if ($user) {
            return $user;
        }
        return null;
    }

    public function updateUser(string $username, string $newUsername, string $newEmail, string $newPassword, bool $enabled, bool $isAdmin) {
        $entityManager = DoctrineConnector::getEntityManager();

        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if ($user) {
            try {
                $user->setUsername($newUsername);
                $user->setEmail($newEmail);
                $user->setEnabled($enabled);
                $user->setIsAdmin($isAdmin);
                $user->setPassword($newPassword);

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