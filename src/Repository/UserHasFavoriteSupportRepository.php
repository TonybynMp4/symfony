<?php

namespace App\Repository;

use App\Entity\UserHasFavoriteSupport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasFavoriteSupport|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasFavoriteSupport|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasFavoriteSupport[]    findAll()
 * @method UserHasFavoriteSupport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasFavoriteSupportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasFavoriteSupport::class);
    }
}
