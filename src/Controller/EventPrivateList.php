<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\UserHasEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EventPrivateList
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $userId = $request->attributes->get("userId");

        $events = $this->em->getRepository(Event::class)->getPrivateEventListInvited($userId);

        foreach ($events as $event) {
            $countParticipation = $this->em->getRepository(UserHasEvent::class)->countEventsParticipation($event->getId());
            $event->setNbParticipation($countParticipation);
        }

        return $events;
    }
}