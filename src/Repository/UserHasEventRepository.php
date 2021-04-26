<?php

namespace App\Repository;

use App\Entity\UserHasEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserHasEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHasEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHasEvent[]    findAll()
 * @method UserHasEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHasEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHasEvent::class);
    }

    public function getEventsListsComingByUser($userId)
    {
        $today = new \DateTime("now");

        return $this->createQueryBuilder("uhe")
            ->leftJoin('uhe.event', 'e')
            ->where("uhe.user = :userId")
            ->andWhere("e.timeToStart >= :today")
            ->orderBy('e.createdAt', 'ASC')
            ->setParameter("today", $today)
            ->setParameter("userId", $userId)
            ->getQuery()
            ->getResult();
    }
}
