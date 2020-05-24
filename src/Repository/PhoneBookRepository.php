<?php

namespace App\Repository;

use App\Entity\PhoneBook;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhoneBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneBook[]    findAll()
 * @method PhoneBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneBookRepository extends ServiceEntityRepository
{
    /**
     * PhoneBookRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhoneBook::class);
    }

    /**
     * @param User|object $user
     *
     * @return PhoneBook[]|int|mixed|string
     */
    public function findAllByUser(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('pb');
        $queryBuilder
            ->leftJoin('pb.user', 'pbu')
            ->addSelect('pbu')
            ->andWhere($queryBuilder->expr()->eq('pb.user', ':user'))
            ->setParameter('user', $user);

        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * @param User|object $user
     *
     * @return PhoneBook[]|int|mixed|string
     */
    public function findAllByUserAndShared(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('pb');
        $queryBuilder
            ->where($queryBuilder->expr()->eq('pb.user', ':user'))
            ->leftJoin('pb.shareds', 'pbs')
            ->orWhere($queryBuilder->expr()->eq('pbs.sharedWithUser', ':user'))
            ->setParameter('user', $user);

        return $queryBuilder->getQuery()->getResult();
    }
}
