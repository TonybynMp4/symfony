<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchTag
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $letters = $request->attributes->get("letters");

        return $this->em->getRepository(Tag::class)->searchTagsByLetters($letters);
    }
}