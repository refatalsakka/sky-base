<?php

namespace App\Entity\Admin;

use App\Enum\Admin\PermissionScope;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use App\Repository\Admin\AdminRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AdminRoleRepository::class)]
#[ApiResource(
    paginationEnabled: false,
)]
class AdminRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: PermissionScope::class)]
    private ?PermissionScope $scope = null;

    /**
     * @var Collection<int, AdminGlobalPermissions>
     */
    #[ORM\OneToMany(targetEntity: AdminGlobalPermissions::class, mappedBy: 'role')]
    private Collection $adminAdminGlobalPermissions;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'role')]
    private Collection $adminUnitPermissions;

    public function __construct()
    {
        $this->adminAdminGlobalPermissions = new ArrayCollection();
        $this->adminUnitPermissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getScope(): ?PermissionScope
    {
        return $this->scope;
    }

    public function setScope(PermissionScope $scope): static
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * @return Collection<int, AdminGlobalPermissions>
     */
    public function getAdminAdminGlobalPermissions(): Collection
    {
        return $this->adminAdminGlobalPermissions;
    }

    public function addAdminGlobalPermissions(AdminGlobalPermissions $globalPermission): static
    {
        if (!$this->adminAdminGlobalPermissions->contains($globalPermission)) {
            $this->adminAdminGlobalPermissions->add($globalPermission);
            $globalPermission->setRole($this);
        }

        return $this;
    }

    public function removeAdminGlobalPermissions(AdminGlobalPermissions $globalPermission): static
    {
        if ($this->adminAdminGlobalPermissions->removeElement($globalPermission)) {
            // set the owning side to null (unless already changed)
            if ($globalPermission->getRole() === $this) {
                $globalPermission->setRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdminUnitPermission>
     */
    public function getAdminUnitPermissions(): Collection
    {
        return $this->adminUnitPermissions;
    }

    public function addAdminUnitPermission(AdminUnitPermission $adminUnitPermission): static
    {
        if (!$this->adminUnitPermissions->contains($adminUnitPermission)) {
            $this->adminUnitPermissions->add($adminUnitPermission);
            $adminUnitPermission->setRole($this);
        }

        return $this;
    }

    public function removeAdminUnitPermission(AdminUnitPermission $adminUnitPermission): static
    {
        if ($this->adminUnitPermissions->removeElement($adminUnitPermission)) {
            // set the owning side to null (unless already changed)
            if ($adminUnitPermission->getRole() === $this) {
                $adminUnitPermission->setRole(null);
            }
        }

        return $this;
    }
}
