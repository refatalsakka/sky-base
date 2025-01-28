<?php

namespace App\Entity\Admin;

use App\Entity\Unit;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Validator\UniqueAdminUnitPermission;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\Admin\AdminUnitPermissionRepository;

#[ORM\Entity(repositoryClass: AdminUnitPermissionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'adminUnitPermission:collection'],
        ),
        new Get(
            normalizationContext: ['groups' => 'adminUnitPermission:read'],
        ),
        new Post(
            validate: true,
            validationContext: ['groups' => ['adminUnitPermission:save']],
        ),
        new Put(
            validate: true,
            validationContext: ['groups' => ['adminUnitPermission:save']],
        ),
        new Delete(),
    ],
    paginationEnabled: false,
)]
#[UniqueAdminUnitPermission(groups: ['adminUnitPermission:save'])]
class AdminUnitPermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['adminUnitPermission:collection', 'adminUnitPermission:read', 'admin:collection', 'admin:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'unitPermissions')]
    #[Groups(['adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private ?Admin $admin = null;

    #[ORM\ManyToOne(inversedBy: 'adminUnitPermissions')]
    #[Groups(['adminUnitPermission:collection', 'adminUnitPermission:read', 'admin:collection', 'admin:read'])]
    private ?AdminRole $role = null;

    #[ORM\ManyToOne(inversedBy: 'adminUnitPermissions')]
    #[Groups(['adminUnitPermission:collection', 'adminUnitPermission:read', 'admin:collection', 'admin:read'])]
    private ?Unit $unit = null;

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

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
