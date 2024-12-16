<?php

namespace App\Service;

use App\Entity\Admin\Admin;
use App\Entity\Admin\ApiToken;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Admin\ApiTokenRepository;

class ApiTokenService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ApiTokenRepository $apiTokenRepository
    ) {
    }

    public function createToken(Admin $admin): ApiToken
    {
        $apiToken = new ApiToken();
        $apiToken->setOwnedBy($admin);

        $this->entityManager->persist($apiToken);
        $this->entityManager->flush();

        return $apiToken;
    }

    public function removeValidTokens(Admin $admin): void
    {
        $existingTokens = $this->apiTokenRepository->findOneBy(['ownedBy' => $admin]);

        if (!$existingTokens) {
            return;
        }

        /** @var ApiToken */
        foreach ($existingTokens as $token) {
            if ($token->isValid()) {
                $token->setValid(false);

                $this->entityManager->persist($token);
            }
        }

        $this->entityManager->flush();
    }

    public function getValidToken(Admin $admin): ?ApiToken
    {
        $token = $this->apiTokenRepository->findOneBy(['ownedBy' => $admin, 'valid' => true]);

        return ($token && $token->isValid()) ? $token : null;
    }
}
