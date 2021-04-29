<?php

namespace App\Repository;

use App\Entity\SupportHasMediaObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SupportHasMediaObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportHasMediaObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportHasMediaObject[]    findAll()
 * @method SupportHasMediaObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportHasMediaObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupportHasMediaObject::class);
    }
}