<?php

namespace App\Repository;

use App\Entity\UserHasTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasTheme[]    findAll()
 * @method UserHasTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasTheme::class);
    }
}
