<?php

namespace App\Controller;

use App\Dto\Admin\AdminDto;
use App\Entity\Admin\Admin;
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
        private ApiTokenService $apiTokenService
    ) {}

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(#[CurrentUser] Admin $admin = null): Response
    {
        if (!$admin) {
            return $this->json([
                'error' => 'Invalid user',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $apiToken = $this->apiTokenService->createToken($admin);

        return $this->json([
            'token' => $apiToken->getToken(),
            'expires_at' => $apiToken->getExpiresAt()?->format(\DateTime::ATOM),
            'token_type' => 'Bearer',
            'admin' => AdminDto::fromEntity($admin),
        ], Response::HTTP_ACCEPTED);
    }

    #[Route('/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(#[CurrentUser] Admin $admin = null): void
    {
        $this->apiTokenService->removeValidTokens($admin);
    }
}
