<?php

namespace App\DataFixtures;

use App\Entity\PhoneBook;
use App\Entity\Shared;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class SharedFixtures
 *
 * @package App\DataFixtures
 */
class SharedFixtures extends Fixture implements OrderedFixtureInterface
{
    use WithRandomsTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();
        $phoneBooks = $manager->getRepository(PhoneBook::class)->findAll();

        for ($i = 1; $i <= 11; $i++) {
            /** @var User $user */
            $user = $this->randomObject($users);

            /** @var PhoneBook $phoneBook */
            $phoneBook = $this->randomObject($phoneBooks);

            $shared = new Shared();
            $shared->setPhoneBook($phoneBook);
            $shared->setSharedByUser($phoneBook->getUser());
            $shared->setSharedWithUser($user);

            $manager->persist($shared);
        }

        $manager->flush();

        $sharedByYourselfs = $manager->getRepository(Shared::class)->findAllSharedWithYourself();

        foreach ($sharedByYourselfs as $sharedByYourself) {
            $manager->remove($sharedByYourself);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
