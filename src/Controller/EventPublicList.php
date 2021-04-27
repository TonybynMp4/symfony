<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\UserHasFavoriteTheme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EventPublicList
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $userId = $request->attributes->get("userId");

        $themes = $this->em->getRepository(UserHasFavoriteTheme::class)->getThemesByUser($userId);

        return $this->em->getRepository(Event::class)->getEventsList($themes);
    }
}