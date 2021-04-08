<?php

namespace App\Repository;

use App\Entity\Support;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Support|null find($id, $lockMode = null, $lockVersion = null)
 * @method Support|null findOneBy(array $criteria, array $orderBy = null)
 * @method Support[]    findAll()
 * @method Support[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Support::class);
    }

    public function getSupportsByThemeId($themeId)
    {
        return $this->createQueryBuilder("s")
            ->where("s.subTheme = :themeId")
            ->setParameter("themeId", $themeId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getSupportsByUserId($userId)
    {
        return $this->createQueryBuilder("s")
            ->where("s.user = :userId")
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult();
    }

    public function searchSupportsByLetters($letters)
    {
        return $this->createQueryBuilder("s")
            ->where("s.title LIKE :letters")
            ->setParameter('letters','%'. $letters .'%')
            ->getQuery()
            ->getResult();
    }
}
