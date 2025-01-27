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
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Groups(['admin:collection', 'admin:read','adminGlobalPermission:collection', 'adminGlobalPermission:read', 'adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['admin:collection', 'admin:read','adminGlobalPermission:collection', 'adminGlobalPermission:read', 'adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['admin:collection', 'admin:read','adminGlobalPermission:collection', 'adminGlobalPermission:read', 'adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $password = null;

    #[ORM\Column(type: 'blob')]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['admin:collection', 'admin:read','adminGlobalPermission:collection', 'adminGlobalPermission:read', 'adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private mixed $image = null;

    /**
     * @var Collection<int, AdminGlobalPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminGlobalPermission::class, mappedBy: 'admin', cascade: ['remove'], orphanRemoval: true)]
    #[Groups(['admin:collection', 'admin:read'])]
    private Collection $globalPermissions;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'admin', cascade: ['remove'], orphanRemoval: true)]
    #[Groups(['admin:collection', 'admin:read'])]
    private Collection $unitPermissions;

    /**
     * @var Collection<int, ApiToken>
     */
    #[ORM\OneToMany(targetEntity: ApiToken::class, mappedBy: 'ownedBy', cascade: ['remove'], orphanRemoval: true)]
    private Collection $apiTokens;

    public function __construct()
    {
        $this->globalPermissions = new ArrayCollection();
        $this->unitPermissions = new ArrayCollection();
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
    public function getGlobalPermissions(): Collection
    {
        return $this->globalPermissions;
    }

    public function addGlobalPermission(AdminGlobalPermission $globalPermission): static
    {
        if (!$this->globalPermissions->contains($globalPermission)) {
            $this->globalPermissions->add($globalPermission);
            $globalPermission->setAdmin($this);
        }

        return $this;
    }

    public function removeGlobalPermission(AdminGlobalPermission $globalPermission): static
    {
        if ($this->globalPermissions->removeElement($globalPermission)) {
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
    public function getUnitPermissions(): Collection
    {
        return $this->unitPermissions;
    }

    public function addUnitPermission(AdminUnitPermission $adminUnitPermission): static
    {
        if (!$this->unitPermissions->contains($adminUnitPermission)) {
            $this->unitPermissions->add($adminUnitPermission);
            $adminUnitPermission->setAdmin($this);
        }

        return $this;
    }

    public function removeUnitPermission(AdminUnitPermission $adminUnitPermission): static
    {
        if ($this->unitPermissions->removeElement($adminUnitPermission)) {
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

        foreach ($this->globalPermissions as $globalPermission) {
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

    public function getImage(): ?string
    {
        if (is_resource($this->image)) {
            return stream_get_contents($this->image);
        }

        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
