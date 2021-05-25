<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class TchatBetweenUser
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request)
    {
        $conversation = $request->attributes->get("conversation");

        if ($request->isMethod('get')) {
            return $this->em->getRepository(Message::class)->getTchatBetweenUsers($conversation);
        } elseif ($request->isMethod('patch')) {
            return $this->em->getRepository(Message::class)->updateConversationRead($conversation);
        } else {
            throw new MethodNotAllowedException(array("post", "put", "delete"),"la méthode utilisée n'est pas accetpée");
        }
    }
}