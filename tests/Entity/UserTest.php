<?php

namespace MiW\Results\Tests\Entity;

use MiW\Results\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package MiW\Results\Tests\Entity
 * @group   users
 */
class UserTest extends TestCase
{
    private User $user, $user1;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->user = new User();
        $this->user1 = new User('test', 'test@mail.es', 'test', true, false);
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     */
    public function testConstructor(): void
    {
        self::assertInstanceOf(User::class, $this->user);
        self::assertInstanceOf(User::class, $this->user1);
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId(): void
    {
        // Assuming that getId() returns null initially
        self::assertEquals(0, $this->user->getId());
        self::assertEquals(0, $this->user1->getId());
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername(): void
    {
        $username = 'test_user';
        $this->user->setUsername($username);
        self::assertSame($username, $this->user->getUsername());
        self::assertSame('test', $this->user1->getUsername());
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);
        self::assertSame($email, $this->user->getEmail());
        self::assertSame('test@mail.es', $this->user1->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled(): void
    {
        $this->user->setEnabled(true);
        self::assertTrue($this->user->isEnabled());
        self::assertTrue($this->user1->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::setIsAdmin()
     * @covers \MiW\Results\Entity\User::isAdmin
     */
    public function testIsSetAdmin(): void
    {
        $this->user->setIsAdmin(true);
        self::assertTrue($this->user->isAdmin());
        self::assertFalse($this->user1->isAdmin());
    }

    /**
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testSetValidatePassword(): void
    {
        $password = 'test_password';
        $this->user->setPassword($password);
        self::assertTrue($this->user->validatePassword($password));
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString(): void
    {
        $username = 'test_user';
        $this->user->setUsername($username);
        self::assertSame('[User:   0 -            test_user -                                - 0 - 0]', $this->user->__toString());
        self::assertSame('[User:   0 -                 test -                   test@mail.es - 1 - 0]', $this->user1->__toString());
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        self::assertIsArray($this->user->jsonSerialize());
        self::assertIsArray($this->user1->jsonSerialize());
    }
}
