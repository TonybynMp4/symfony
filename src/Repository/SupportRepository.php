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

    public function getSupportsByThemeIdUser($themeId)
    {
        return $this->createQueryBuilder("s")
            ->select("s.title", "s.subtitle", "s.type", "s.type2", "u.name", "s.createdAt", "s.lastUpdated", "s.level", "m.filePath", "m.description")
            ->leftJoin('s.user', 'u')
            ->leftJoin('s.medias', 'shm')
            ->leftJoin("shm.media", 'm')
            ->where("s.subTheme = :themeId")
            ->setParameter("themeId", $themeId)
            ->getQuery()
            ->getResult();
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

    public function getPromotedSupports($LanguageIds, $themeIds)
    {
        return $this->createQueryBuilder("s")
            ->where('s.language IN (:languageIds)')
            ->andWhere('s.subTheme IN (:themeIds)')
            ->orderBy('s.createdAt', 'ASC')
            ->setParameter('languageIds', $LanguageIds)
            ->setParameter('themeIds', $themeIds)
            ->getQuery()
            ->getResult();
    }
}
