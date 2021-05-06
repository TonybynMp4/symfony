<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getEventsList($themes)
    {
        return $this->createQueryBuilder("e")
            ->where("e.type =:public")
            ->andWhere("e.theme IN(:themes)")
            ->setParameter("public", false)
            ->setParameter('themes', array_values($themes))
            ->orderBy('e.createdAt', 'ASC')
            ->setMaxResults(30)
            ->getQuery()
            ->getResult();
    }

    public function getPrivateEventListInvited($userId)
    {
        return $this->createQueryBuilder("e")
            ->leftJoin('e.users', 'uhe')
            ->where("uhe.user = :userId")
            ->andWhere("e.type = :true")
            ->orderBy('e.createdAt', 'ASC')
            ->setParameter("userId", $userId)
            ->setParameter("true", true)
            ->getQuery()
            ->getResult();
    }
}
