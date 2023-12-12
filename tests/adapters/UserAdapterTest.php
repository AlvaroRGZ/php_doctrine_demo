<?php
/**
 * tests/adapters/UserAdapterTest.php
 *
 * @package  MiW\Results\Tests\Adapters
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Adapters;

use MiW\Results\Adapters\UserAdapter;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use PHPUnit\Framework\TestCase;

/**
 * Class UserAdapterTest
 *
 * @package MiW\Results\Tests\Adapters
 */
class UserAdapterTest extends TestCase
{
    private UserAdapter $userAdapter;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->userAdapter = new UserAdapter();
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
     * Test createUser method.
     */
    public function testCreateUser(): void
    {
        $username = 'test_user';
        $email = 'test@example.com';
        $password = 'test_password';

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        $result = $this->userAdapter->createUser($user);

        self::assertTrue($result);

        $result = $this->userAdapter->createUser($user);

        self::assertFalse($result);

        // Clean up the created user
        $this->cleanUser($username);
    }

    /**
     * Test deleteUser method.
     */
    public function testDeleteUser(): void
    {
        $username = 'test_user_delete';

        $this->createDefaultUser($username);

        $result = $this->userAdapter->deleteUser($username);

        self::assertTrue($result);

        $result = $this->userAdapter->deleteUser('foo');

        self::assertFalse($result);

        // Clean up the created user if fail
        $this->cleanUser($username);
    }

    /**
     * Test existsUserByUsername method.
     */
    public function testExistsUserByUsername(): void
    {
        $username = 'read_only';

        // Hay que crear primero el usuario para probar la base de datos
        $this->createDefaultUser("read_only");

        $result = $this->userAdapter->existsUserByUsername($username);

        self::assertTrue($result);

        $result = $this->userAdapter->existsUserByUsername('foo');

        self::assertFalse($result);

        // Clean up the created user
        $this->cleanUser($username);
    }

    /**
     * Test readUserByUsername method.
     */
    public function testReadUserByUsername(): void
    {
        $username = 'read_only';

        // Create a user for testing
        $this->createDefaultUser($username);

        $user = $this->userAdapter->readUserByUsername($username);

        self::assertInstanceOf(User::class, $user);

        $user = $this->userAdapter->readUserByUsername('foo');

        self::assertNull($user);

        // Clean up the created user
        $this->cleanUser($username);
    }

    /**
     * Test readUserById method.
     */
    public function testReadUserById(): void
    {
        $username = 'read_by_id';

        // Create a user for testing
        $this->createDefaultUser($username);
        $createdUser = $this->userAdapter->readUserByUsername($username);

        $user = $this->userAdapter->readUserById($createdUser->getId());

        self::assertInstanceOf(User::class, $user);

        $user = $this->userAdapter->readUserById(-1);

        self::assertNull($user);

        // Clean up the created user
        $this->cleanUser($username);
    }

    /**
     * Test updateUser method.
     */
    public function testUpdateUser(): void
    {
        $username = 'user_to_update';
        $newUsername = 'updated_user';
        $newEmail = 'updated_user@example.com';
        $newPassword = 'updated_password';
        $enabled = true;
        $isAdmin = true;

        // Create a user for testing
        $this->createDefaultUser($username);

        $result = $this->userAdapter->updateUser(
            $username,
            $newUsername,
            $newEmail,
            $newPassword,
            $enabled,
            $isAdmin
        );

        self::assertTrue($result);

        $result = $this->userAdapter->updateUser(
            'foo',
            $newUsername,
            $newEmail,
            $newPassword,
            $enabled,
            $isAdmin
        );

        self::assertFalse($result);

        // Clean up the created user
        $this->cleanUser($newUsername);
    }
}
