<?php

namespace App\Entity\Admin;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Repository\Admin\AdminGlobalPermissionRepository;

#[ORM\Entity(repositoryClass: AdminGlobalPermissionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'adminGlobalPermission:collection'],
        ),
        new Get(
            normalizationContext: ['groups' => 'adminGlobalPermission:read'],
        ),
        new Post(),
        new Put(),
        new Delete()
    ],
    paginationEnabled: false,
)]
class AdminGlobalPermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['adminGlobalPermission:collection', 'adminGlobalPermission:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'globalPermissions')]
    #[Groups(['adminGlobalPermission:collection', 'adminGlobalPermission:read'])]
    private ?Admin $admin = null;

    #[ORM\ManyToOne(inversedBy: 'adminGlobalPermissions')]
    #[Groups(['adminGlobalPermission:collection', 'adminGlobalPermission:read', 'admin:collection', 'admin:read'])]
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
