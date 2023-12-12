<?php

/**
 * tests/Entity/ResultTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;

use DateTime;
use MiW\Results\Entity\{ Result, User };

/**
 * Class ResultTest
 *
 * @package MiW\Results\Tests\Entity
 */
class ResultTest extends \PHPUnit\Framework\TestCase
{
    private User $user;

    private Result $result;

    private const USERNAME = 'uSeR ñ¿?Ñ';
    private const POINTS = 2018;

    private \DateTime $time;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->user = new User();
        $this->user->setUsername(self::USERNAME);
        $this->time = new DateTime('now');
        $this->result = new Result(
            self::POINTS,
            $this->user,
            $this->time
        );
    }

    /**
     * Implement testConstructor
     *
     * @covers \MiW\Results\Entity\Result::__construct()
     * @covers \MiW\Results\Entity\Result::getId()
     * @covers \MiW\Results\Entity\Result::getResult()
     * @covers \MiW\Results\Entity\Result::getUser()
     * @covers \MiW\Results\Entity\Result::getTime()
     *
     * @return void
     */
    public function testConstructor(): void
    {
        self::assertEquals(self::POINTS, $this->result->getResult());
        self::assertSame($this->user, $this->result->getUser());
        self::assertSame($this->time, $this->result->getTime());
    }

    /**
     * Implement testGet_Id().
     *
     * @covers \MiW\Results\Entity\Result::getId()
     * @return void
     */
    public function testGetId():void
    {
        self::assertEquals(0, $this->result->getId());
    }

    /**
     * Implement testResult().
     *
     * @covers \MiW\Results\Entity\Result::setResult
     * @covers \MiW\Results\Entity\Result::getResult
     * @return void
     */
    public function testResult(): void
    {
        $this->result->setResult(100);
        self::assertEquals(100, $this->result->getResult());
    }

    /**
     * Implement testUser().
     *
     * @covers \MiW\Results\Entity\Result::setUser()
     * @covers \MiW\Results\Entity\Result::getUser()
     * @return void
     */
    public function testUser(): void
    {
        $newUser = new User();
        $newUser->setUsername('NewUser');
        $this->result->setUser($newUser);
        self::assertSame($newUser, $this->result->getUser());
    }

    /**
     * Implement testTime().
     *
     * @covers \MiW\Results\Entity\Result::setTime
     * @covers \MiW\Results\Entity\Result::getTime
     * @return void
     */
    public function testTime(): void
    {
        $newTime = new DateTime('tomorrow');
        $this->result->setTime($newTime);
        self::assertSame($newTime, $this->result->getTime());
    }

    /**
     * Implement testTo_String().
     *
     * @covers \MiW\Results\Entity\Result::__toString
     * @return void
     */
    public function testToString(): void
    {
        self::assertIsString((string)$this->result);
    }

    /**
     * Implement testJson_Serialize().
     *
     * @covers \MiW\Results\Entity\Result::jsonSerialize
     * @return void
     */
    public function testJsonSerialize(): void
    {
        $expected = [
            'id' => 0,
            'result' => self::POINTS,
            'user' => $this->user,
            'time' => $this->time->format('Y-m-d H:i:s'),
        ];

        self::assertSame($expected, $this->result->jsonSerialize());
    }
}
