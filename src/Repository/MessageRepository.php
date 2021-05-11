<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function getTchatBetweenUsers($ownerId, $userDeliveryId)
    {
        return $this->createQueryBuilder("m")
            ->where("m.owner = :ownerId OR m.userDelivery = :userDeliveryId")
            ->orWhere("m.userDelivery = :ownerId OR m.owner = :userDeliveryId")
            ->setParameter("ownerId", $ownerId)
            ->setParameter("userDeliveryId", $userDeliveryId)
            ->orderBy('m.lastUpdated', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getTchatList($ownerId)
    {
        return $this->createQueryBuilder("m")
            ->where("m.owner = :ownerId OR m.userDelivery = :ownerId")
            ->leftJoin('m.owner', 'o')
            ->leftJoin('m.userDelivery', 'u')
            ->setParameter("ownerId", $ownerId)
            ->groupBy('m.conversation')
            ->orderBy('m.lastUpdated', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countNbUnreadByConversation($conversationId)
    {
        return $this->createQueryBuilder("m")
            ->select("count(m.view) as NbUnread")
            ->where("m.view = :view")
            ->andWhere("m.conversation = :conversationId")
            ->setParameter('conversationId',$conversationId)
            ->setParameter('view',false)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
