<?php

namespace App\Controller;

use App\Entity\Admin\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(#[CurrentUser] Admin $admin = null): Response
    {
        return $this->json([
            'admin' => $admin ? $admin->getId() : null
        ]);
    }
}
