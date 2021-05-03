<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\UserHasEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EventOwnerList
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $userId = $request->attributes->get("userId");
        $type = $request->attributes->get("type");

        return $this->em->getRepository(Event::class)->findBy(["owner" => $userId, "type" => $type]);
    }
}