<?php

namespace App\Repository;

use App\Entity\DrinkPosition;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DrinkPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrinkPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrinkPosition[]    findAll()
 * @method DrinkPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkPositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrinkPosition::class);
    }

    public function findById(int $id, User $user)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->innerJoin('p.drink', 'd')
            ->where('d.user = :user_id')
            ->andWhere('p.id = :iid')
            ->setParameter('id', $id)
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
