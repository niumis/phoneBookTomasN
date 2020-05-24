<?php

namespace App\DataFixtures;

use App\Entity\PhoneBook;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class PhoneBookFixtures
 *
 * @package App\DataFixtures
 */
class PhoneBookFixtures extends Fixture implements OrderedFixtureInterface
{
    use WithRandomsTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 1; $i <= 9; $i++) {
            $user = $this->randomObject($users);

            $phoneBook = new PhoneBook();
            $phoneBook->setUser($user);
            $phoneBook->setFullName($user->getUsername().' Contact'.$i);
            $phoneBook->setPhone('+3706'."$i$i$i$i$i$i$i");

            $manager->persist($phoneBook);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
