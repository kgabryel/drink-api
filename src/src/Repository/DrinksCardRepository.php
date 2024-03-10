<?php

namespace App\Repository;

use App\Entity\DrinksCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DrinksCard>
 *
 * @method DrinksCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrinksCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrinksCard[]    findAll()
 * @method DrinksCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinksCardRepository extends ServiceEntityRepository implements FindByIdInterface
{
    use FindTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrinksCard::class);
    }
}
