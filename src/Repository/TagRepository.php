<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function searchTagsByLetters($letters)
    {
        return $this->createQueryBuilder("t")
            ->select("t.id", "t.name")
            ->where("t.name LIKE :letters")
            ->setParameter('letters','%'. $letters .'%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}