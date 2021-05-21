<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchUser
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $letters = $request->attributes->get("letters");

        $userId = $request->attributes->get("userId");

        return $this->em->getRepository(User::class)->searchUsersByLetters($letters, $userId);
    }
}