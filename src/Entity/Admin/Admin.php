<?php

namespace App\Entity\Admin;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Admin\AdminRepository;
use Doctrine\Common\Collections\Collection;
use App\Entity\Admin\AdminGlobalPermission;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => 'admin:collection'],
        ),
        new Get(
            normalizationContext: ['groups' => 'admin:read'],
        ),
        new Post(),
        new Put(),
        new Delete()
    ],
    forceEager: false,
    paginationEnabled: false,
)]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['admin:collection', 'admin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:collection', 'admin:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['admin:collection', 'admin:read'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var Collection<int, AdminGlobalPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminGlobalPermission::class, mappedBy: 'admin', cascade: ['remove'], orphanRemoval: true)]
    #[Groups(['admin:collection', 'admin:read'])]
    private Collection $adminGlobalPermissions;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'admin', cascade: ['remove'], orphanRemoval: true)]
    #[Groups(['admin:collection', 'admin:read'])]
    private Collection $adminUnitPermissions;

    /**
     * @var Collection<int, ApiToken>
     */
    #[ORM\OneToMany(targetEntity: ApiToken::class, mappedBy: 'ownedBy', cascade: ['remove'], orphanRemoval: true)]
    private Collection $apiTokens;

    public function __construct()
    {
        $this->adminGlobalPermissions = new ArrayCollection();
        $this->adminUnitPermissions = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
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
     * @return Collection<int, AdminGlobalPermission>
     */
    public function getAdminGlobalPermissions(): Collection
    {
        return $this->adminGlobalPermissions;
    }

    public function addAdminGlobalPermission(AdminGlobalPermission $globalPermission): static
    {
        if (!$this->adminGlobalPermissions->contains($globalPermission)) {
            $this->adminGlobalPermissions->add($globalPermission);
            $globalPermission->setAdmin($this);
        }

        return $this;
    }

    public function removeAdminGlobalPermission(AdminGlobalPermission $globalPermission): static
    {
        if ($this->adminGlobalPermissions->removeElement($globalPermission)) {
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
        $roles = [];

        foreach ($this->adminGlobalPermissions as $globalPermission) {
            $roles[] = $globalPermission->getRole()->getName();
        }

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @return Collection<int, ApiToken>
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): static
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens->add($apiToken);
            $apiToken->setOwnedBy($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): static
    {
        if ($this->apiTokens->removeElement($apiToken)) {
            // set the owning side to null (unless already changed)
            if ($apiToken->getOwnedBy() === $this) {
                $apiToken->setOwnedBy(null);
            }
        }

        return $this;
    }
}
