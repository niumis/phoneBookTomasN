<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PhoneBookControllerTest
 *
 * @package App\Tests
 */
class PhoneBookControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/en/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Phone Book');
    }

    public function testRegister()
    {
        $client = static::createClient();

        $client->request('GET', '/en/register');

        $client->submitForm(
            'Register',
            [
                'registration_form[username]' => 'user5',
                'registration_form[plainPassword]' => '+37061234567',
                'registration_form[agreeTerms]' => 1,
            ]
        );

        self::$container->get(EntityManagerInterface::class)->flush();

        $this->assertSelectorExists('div:contains("Register")');
    }
}
