<?php

namespace App\Service;

use App\Entity\Admin\Admin;
use App\Entity\Admin\ApiToken;
use Doctrine\ORM\EntityManagerInterface;

class ApiTokenService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createTokenForAdmin(Admin $admin): ApiToken
    {
        $apiToken = new ApiToken();
        $apiToken->setOwnedBy($admin);

        $this->entityManager->persist($apiToken);
        $this->entityManager->flush();

        return $apiToken;
    }
}
