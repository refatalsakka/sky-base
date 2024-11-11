<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\Admin\AdminGlobalPermissionsRepository;

#[ORM\Entity(repositoryClass: AdminGlobalPermissionsRepository::class)]
#[ApiResource(
    paginationEnabled: false,
)]
class AdminGlobalPermissions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adminGlobalPermissions')]
    private ?Admin $admin = null;

    #[ORM\ManyToOne(inversedBy: 'adminGlobalPermissions')]
    private ?AdminRole $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    public function getRole(): ?AdminRole
    {
        return $this->role;
    }

    public function setRole(?AdminRole $role): static
    {
        $this->role = $role;

        return $this;
    }
}
