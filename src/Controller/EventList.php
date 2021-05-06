<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\UserHasEvent;
use App\Entity\UserHasFavoriteTheme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EventList
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

        if ($type == "pub") {
            $themes = $this->em->getRepository(UserHasFavoriteTheme::class)->getIdThemesByUser($userId);

            return $this->em->getRepository(Event::class)->getEventsList($themes);
        } elseif ($type == "priv") {
            $events = $this->em->getRepository(Event::class)->getPrivateEventListInvited($userId);

            foreach ($events as $event) {
                $countParticipation = $this->em->getRepository(UserHasEvent::class)->countEventsParticipation($event->getId());
                $event->setNbParticipation($countParticipation);
            }

            return $events;
        }
    }
}