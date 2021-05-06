<?php

namespace App\Controller;

use App\Entity\UserHasFavoriteTheme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FavoriteThemeUser
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $userId = $request->attributes->get("userId");

        return $this->em->getRepository(UserHasFavoriteTheme::class)->findBy(["user" => $userId]);
    }
}