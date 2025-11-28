<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

class UnitTestController extends Controller
{
    private $_entityManager;
    private $_passwordEncoder;
    private HttpClientInterface $httpClient;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        HttpClientInterface $httpClient
    ) {
        $this->_entityManager   = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
        $this->httpClient       = $httpClient;
    }

    /**
     * @Route("unit/test", name="unit_test", methods="GET")
     */
    public function testUnit(Request $request) :RedirectResponse
    {
        $token = $request->headers->get('JWT-TOKEN');

        if (!$toten) {
            return new JsonResponse(['token missing', JsonResponse::HTTP_FORBIDDEN]);
        }

        dd($token);

        $response = $this->httpClient->request(
            'GET',
            'http://localhost/api/users',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/ld+json', // Pour API Platform,
                    'verify_peer' => false
                ]
            ]
        );

        return new JsonResponse([
            'status'            => $response->getStatusCode() === 200 ? 'OK' : 'ERROR',
            'users_endpoint'    => $response->getStatusCode()
        ]);
    }
}