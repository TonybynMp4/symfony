<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\UserHasEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventParticipation
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $userId = $request->attributes->get("userId");
        $eventId = $request->attributes->get("eventId");

        $nbUserHasEvent = count($this->em->getRepository(UserHasEvent::class)->findBy(["event" => $eventId, "accepted" => true]));

        $event = $this->em->getRepository(Event::class)->findOneBy(["id" => $eventId]);

        if ($nbUserHasEvent < $event->getNbMaxParticipants()) {
            $userHasEvent = $this->em->getRepository(UserHasEvent::class)->findOneBy(["user" => $userId, "event" => $eventId]);
            $userHasEvent->setAccepted(true);
            $this->em->flush();
            return new Response("OK", Response::HTTP_NO_CONTENT);
        } else {
            return new Response("Nous sommes désolé cet évènement est déjà complet", Response::HTTP_CONFLICT);
        }
    }
}