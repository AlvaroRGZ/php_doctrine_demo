<?php

/**
 * tests/Adapters/ResultAdapterTest.php
 *
 * @package  MiW\Results\Tests\Adapters
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Adapters;

use MiW\Results\Adapters\ResultAdapter;
use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultAdapterTest
 *
 * @package MiW\Results\Tests\Adapters
 * @runInSeparateProcess
 */
class ResultAdapterTest extends TestCase
{
    private ResultAdapter $resultAdapter;
    private UserAdapter $userAdapter;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->resultAdapter = new ResultAdapter();
        $this->userAdapter = new UserAdapter();
    }

    protected function cleanResult(string $username)
    {
        // Clean up the created result
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if ($user) {
            $resultRepository = $entityManager->getRepository(Result::class);
            $result = $resultRepository->findOneBy(['user' => $user->getId()]);

            if ($result) {
                $entityManager->remove($result);
                $entityManager->flush();
            }
        }
    }

    protected function createDefaultResult(string $username, int $result = 100)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($username . '@example.com');
        $user->setPassword('password');

        $this->userAdapter->createUser($user);

        $this->resultAdapter->createResultFromScratch($result, $username);
    }

    protected function cleanUser(string $username) {
        // Clean up the created user
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $createdUser = $userRepository->findOneBy(['username' => $username]);

        if ($createdUser) {
            $entityManager->remove($createdUser);
            $entityManager->flush();
        }
    }

    protected function createDefaultUser(string $username) {
        $email = $username . '@example.com';
        $password = 'password';

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        $this->userAdapter->createUser($user);
    }

    /**
     * Test createResultFromScratch method.
     */
    public function testCreateResultFromScratch(): void
    {
        $username = 'create_result_user';
        $resultValue = 150;
        $this->createDefaultUser($username);
        $result = $this->resultAdapter->createResultFromScratch($resultValue, $username);

        self::assertTrue($result);

        // Clean up the created result
        $this->cleanResult($username);
        $this->cleanUser($username);
    }

    /**
     * Test deleteResult method.
     */
    public function testDeleteResult(): void
    {
        $username = 'delete_result_user';
        $this->createDefaultResult($username);

        $result = $this->resultAdapter->deleteResult($username);

        self::assertTrue($result);

        $result = $this->resultAdapter->deleteResult('foo');

        self::assertFalse($result);

        // Clean up the created result if fail
        $this->cleanResult($username);
        $this->cleanUser($username);
    }

    /**
     * Test readResultByResultname method.
     */
    public function testReadResultByResultname(): void
    {
        $username = 'read_only';

        // Create a result for testing
        $this->createDefaultResult($username);

        $result = $this->resultAdapter->readResultByResultname($username);

        self::assertInstanceOf(Result::class, $result);

        $result = $this->resultAdapter->readResultByResultname('foo');

        self::assertNull($result);

        // Clean up the created result
        $this->cleanResult($username);
        $this->cleanUser($username);
    }

    /**
     * Test readResultById method.
     */
    public function testReadResultById(): void
    {
        $username = 'read_by_id';

        // Create a result for testing
        $this->createDefaultResult($username);
        $createdUser = $this->resultAdapter->readResultByResultname($username);

        $result = $this->resultAdapter->readResultById($createdUser->getId());

        self::assertInstanceOf(Result::class, $result);

        $result = $this->resultAdapter->readResultById(-1);

        self::assertNull($result);

        // Clean up the created result
        $this->cleanResult($username);
        $this->cleanUser($username);
    }

    /**
     * Test updateResult method.
     */
    public function testUpdateResult(): void
    {
        $username = 'result_to_update';
        $newUsername = 'updated_result_user';
        $newResultValue = 200;

        // Create a result for testing
        $this->createDefaultUser($newUsername);
        $this->createDefaultResult($username);

        $result = $this->resultAdapter->updateResult($newResultValue, $username, $newUsername);

        self::assertTrue($result);

        // Clean up the created result
        $this->cleanResult($newUsername);
        $this->cleanUser($username);
        $this->cleanUser($newUsername);
    }
}
