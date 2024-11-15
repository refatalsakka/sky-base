<?php

namespace App\Entity\Admin;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Admin\PermissionScope;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Admin\AdminGlobalPermission;
use Doctrine\Common\Collections\Collection;
use App\Repository\Admin\AdminRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdminRoleRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'AdminRole:collection'],
        ),
        new Get(
            normalizationContext: ['groups' => 'AdminRole:read'],
        ),
    ],
    paginationEnabled: false,
)]
class AdminRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['AdminRole:collection', 'AdminRole:read', 'adminGlobalPermission:collection', 'adminGlobalPermission:read', 'admin:collection', 'admin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['AdminRole:collection', 'AdminRole:read', 'adminGlobalPermission:collection', 'adminGlobalPermission:read', 'admin:collection', 'admin:read'])]
    private ?string $name = null;

    #[ORM\Column(enumType: PermissionScope::class)]
    #[Groups(['AdminRole:collection', 'AdminRole:read', 'adminGlobalPermission:collection', 'adminGlobalPermission:read', 'admin:collection', 'admin:read'])]
    private ?PermissionScope $scope = null;

    /**
     * @var Collection<int, AdminGlobalPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminGlobalPermission::class, mappedBy: 'role')]
    private Collection $adminGlobalPermissions;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'role')]
    private Collection $adminUnitPermissions;

    public function __construct()
    {
        $this->adminGlobalPermissions = new ArrayCollection();
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
     * @return Collection<int, AdminGlobalPermission>
     */
    public function getAdminGlobalPermission(): Collection
    {
        return $this->adminGlobalPermissions;
    }

    public function addAdminGlobalPermission(AdminGlobalPermission $globalPermission): static
    {
        if (!$this->adminGlobalPermissions->contains($globalPermission)) {
            $this->adminGlobalPermissions->add($globalPermission);
            $globalPermission->setRole($this);
        }

        return $this;
    }

    public function removeAdminGlobalPermission(AdminGlobalPermission $globalPermission): static
    {
        if ($this->adminGlobalPermissions->removeElement($globalPermission)) {
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
