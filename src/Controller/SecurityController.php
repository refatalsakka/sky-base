<?php

namespace App\Controller;

use App\Entity\Admin\Admin;
use Psr\Log\LoggerInterface;
use App\Service\ApiTokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ApiTokenService $apiTokenService,
        private LoggerInterface $logger
    ) {}

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(#[CurrentUser] Admin $admin = null): Response
    {
        $apiToken = $this->apiTokenService->createTokenForAdmin($admin);

        return $this->json([
            'token' => $apiToken->getToken(),
            'expires_at' => $apiToken->getExpiresAt()?->format(\DateTime::ATOM),
            'token_type' => 'Bearer'
        ], Response::HTTP_ACCEPTED);
    }

    #[Route('/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(): void
    {
    }
}
