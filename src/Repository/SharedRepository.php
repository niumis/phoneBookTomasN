<?php

namespace App\Repository;

use App\Entity\Shared;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shared|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shared|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shared[]    findAll()
 * @method Shared[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SharedRepository extends ServiceEntityRepository
{
    /**
     * SharedRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shared::class);
    }

    /**
     * @param User|object $user
     *
     * @return Shared[]|int|mixed|string
     */
    public function findAllByUserShared(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('sp, s')
            ->leftJoin('s.phoneBook', 'sp')
            ->andWhere($queryBuilder->expr()->eq('s.sharedWithUser', ':user'))
            ->setParameter('user', $user);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param User|object $user
     *
     * @return Shared[]|int|mixed|string
     */
    public function findAllSharedWithUsers(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('sp, s')
            ->leftJoin('s.phoneBook', 'sp')
            ->andWhere($queryBuilder->expr()->eq('s.sharedByUser', ':user'))
            ->setParameter('user', $user);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return Shared[]|int|mixed|string
     */
    public function findAllSharedWithYourself()
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('sp, s')
            ->leftJoin('s.phoneBook', 'sp')
            ->andWhere($queryBuilder->expr()->eq('s.sharedByUser', 's.sharedWithUser'));

        return $queryBuilder->getQuery()->getResult();
    }
}
