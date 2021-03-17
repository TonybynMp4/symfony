<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TchatBetweenUser
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $ownerId = $request->attributes->get("ownerId");
        $deliveryUserId = $request->attributes->get("deliveryUserId");

        return $this->em->getRepository(Message::class)->getTchatBetweenUsers($ownerId, $deliveryUserId);
    }
}