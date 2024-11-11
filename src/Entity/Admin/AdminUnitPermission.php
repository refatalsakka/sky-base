<?php

namespace App\Entity\Admin;

use App\Entity\Unit;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\Admin\AdminUnitPermissionRepository;

#[ORM\Entity(repositoryClass: AdminUnitPermissionRepository::class)]
#[ApiResource(
    paginationEnabled: false,
)]
class AdminUnitPermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adminUnitPermissions')]
    private ?Admin $admin = null;

    #[ORM\ManyToOne(inversedBy: 'adminUnitPermissions')]
    private ?AdminRole $role = null;

    #[ORM\ManyToOne(inversedBy: 'adminUnitPermissions')]
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
