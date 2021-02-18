<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPassword
{
    protected $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @param User $data
     * @param UserRepository $repository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __invoke(User $data, UserRepository $repository, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $content = json_decode($request->getContent());
        $actualUser = $repository->findOneBy(array("email" => $content->email));

        if (!$actualUser) {
            throw new NotFoundHttpException("L'adresse email ne correspond à aucun utilisateur.");
        }

        if (in_array("ROLE_ADMIN", $actualUser->getRoles())) {
            throw new AccessDeniedHttpException("Il est impossible de modifier le mot de passe de l'administrateur");
        }

        $newEncodedPassword = $passwordEncoder->encodePassword($actualUser, $content->password);
        $actualUser->setPassword($newEncodedPassword);

        try {
            $this->em->flush();
            dump("changement de mot de passe effectué avec succès");
        } catch(Exception $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        die();
    }
}