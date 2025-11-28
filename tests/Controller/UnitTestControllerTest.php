<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnitTestControllerTest extends WebTestCase
{
    /**
     * @Route("/unit/test/7", name="unit_test_7", methods={"GET"})
     */
    public function testUnit7(Request $request, LoggerInterface $logger): JsonResponse
    {
        $token = $request->headers->get('JWT-TOKEN');
        if (!$token) {
            return new JsonResponse(['message' => 'token missing'], JsonResponse::HTTP_FORBIDDEN);
        }

        $logger->info('TESTING /api/users with POST method');

        // Internal sub-request to avoid deadlock
        $subRequest = Request::create(
            '/api/users',
            'POST',
            [],
            [], // files
            [], // cookies
            [
                'HTTP_Authorization' => 'Bearer '.$token,
                'HTTP_Accept' => 'application/ld+json',
                'CONTENT_TYPE' => 'application/ld+json',
            ],
            json_encode([
                'name' => 'USER1',
                "birthdate"=>"03-03-1998",
                "gender" => true,
                "email" => "admin3@test.com",
                "password" => "admin123"
            ])
        );

        $resp = $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);

        $statusCode = $resp->getStatusCode();
        $status = in_array($statusCode, [200, 201], true) ? 'OK' : 'ERROR';

        return new JsonResponse([
            'status'         => $status,
            'users_endpoint' => $statusCode,
        ], $statusCode);
    }
}