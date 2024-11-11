<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\Admin\AdminRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ApiResource(
    paginationEnabled: false,
)]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var Collection<int, AdminGlobalPermissions>
     */
    #[ORM\OneToMany(targetEntity: AdminGlobalPermissions::class, mappedBy: 'admin')]
    private Collection $adminAdminGlobalPermissions;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'admin')]
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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
            $globalPermission->setAdmin($this);
        }

        return $this;
    }

    public function removeAdminGlobalPermissions(AdminGlobalPermissions $globalPermission): static
    {
        if ($this->adminAdminGlobalPermissions->removeElement($globalPermission)) {
            // set the owning side to null (unless already changed)
            if ($globalPermission->getAdmin() === $this) {
                $globalPermission->setAdmin(null);
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
            $adminUnitPermission->setAdmin($this);
        }

        return $this;
    }

    public function removeAdminUnitPermission(AdminUnitPermission $adminUnitPermission): static
    {
        if ($this->adminUnitPermissions->removeElement($adminUnitPermission)) {
            // set the owning side to null (unless already changed)
            if ($adminUnitPermission->getAdmin() === $this) {
                $adminUnitPermission->setAdmin(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_ADMIN'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}
