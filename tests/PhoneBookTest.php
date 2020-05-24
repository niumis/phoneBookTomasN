<?php

namespace App\Tests;

use App\Entity\PhoneBook;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class PhoneBookTest
 *
 * @package App\Tests
 */
class PhoneBookTest extends TestCase
{
    public function testPhoneBookEntity()
    {
        $user = new User();

        $phoneBook = new PhoneBook();
        $phoneBook->setUser($user);
        $phoneBook->setFullName('Vardenis Pavardenis');
        $phoneBook->setPhone('+37061298123');

        $this->assertInstanceOf(User::class, $phoneBook->getUser());
        $this->assertInstanceOf(PhoneBook::class, $phoneBook);
        $this->assertIsString('string', $phoneBook->getFullName());
        $this->assertGreaterThanOrEqual($phoneBook->getFullName(), 1, 'Fullname must be grater or equal than 1');
        $this->assertIsString('string', $phoneBook->getPhone());
        $this->assertEquals(12, strlen($phoneBook->getPhone()), 'Bad phone number?');
    }
}
