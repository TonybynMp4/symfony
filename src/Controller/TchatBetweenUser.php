<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
            $userId = $request->attributes->get("userId");

            $messages = $this->em->getRepository(Message::class)->getTchatBetweenUsers($conversation);

            foreach ($messages as $message) {
                if ($message->getOwner()->getId() == $userId) {
                    if ($message->isViewOwner() != true) {
                        $message->setViewOwner(true);
                    }
                } elseif ($message->getUserDelivery()->getId() == $userId) {
                    if ($message->isViewUserDelivery() != true) {
                        $message->setViewUserDelivery(true);
                    }
                }
            }

            try{
                $this->em->flush();
                return new Response("OK", Response::HTTP_NO_CONTENT);
            } catch(\Exception $e){
                throw new BadRequestHttpException($e);
            }

        } else {
            throw new MethodNotAllowedException(array("post", "put", "delete"),"la méthode utilisée n'est pas accetpée");
        }
    }
}