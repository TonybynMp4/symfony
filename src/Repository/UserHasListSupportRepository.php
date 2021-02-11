<?php

namespace App\Repository;

use App\Entity\UserHasListSupport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasListSupport|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasListSupport|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasListSupport[]    findAll()
 * @method UserHasListSupport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasListSupportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasListSupport::class);
    }
}
