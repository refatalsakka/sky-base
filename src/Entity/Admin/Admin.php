<?php

namespace App\Entity\Admin;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Validator\Base64Image;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\Admin\AdminRepository;
use App\Entity\Admin\AdminGlobalPermission;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
        new Post(
            denormalizationContext: ['groups' => 'admin:save'],
        ),
        new Patch(
            denormalizationContext: ['groups' => 'admin:save'],
        ),
        new Delete()
    ],
    forceEager: false,
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['username'])]
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
    #[Groups(['admin:collection', 'admin:read', 'admin:save', 'adminGlobalPermission:collection', 'adminGlobalPermission:read', 'adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['admin:collection', 'admin:read', 'admin:save', 'adminGlobalPermission:collection', 'adminGlobalPermission:read', 'adminUnitPermission:collection', 'adminUnitPermission:read'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['admin:save'])]
    private ?string $password = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Base64Image]
    #[Groups(['admin:collection', 'admin:read', 'admin:save'])]
    private ?string $image = null;

    /**
     * @var Collection<int, AdminGlobalPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminGlobalPermission::class, mappedBy: 'admin', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['admin:collection', 'admin:read', 'admin:save'])]
    private Collection $globalPermissions;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'admin', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['admin:collection', 'admin:read', 'admin:save'])]
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

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
