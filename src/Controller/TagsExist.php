<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TagsExist
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $tagsList = json_decode($request->getContent(), true);

        $arrayTags = [];
        foreach ($tagsList as $tag) {
            $tagRes = $this->em->getRepository(Tag::class)->findOneBy(["name" => $tag]);

            if ($tagRes) {
                $arrayTags[$tag] = $tagRes->getId();
            }
        }

        return $arrayTags;
    }
}