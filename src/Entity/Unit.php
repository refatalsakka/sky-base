<?php

namespace App\Entity;

use App\Entity\Individual;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UnitRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Admin\AdminUnitPermission;
use App\Provider\UnitIndividualsProvider;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Validator\PreventUnitDeletionIfHasIndividuals;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/units',
            normalizationContext: ['groups' => 'unit:collection'],
        ),
        new GetCollection(
            uriTemplate: '/units/{id}/officers',
            normalizationContext: ['groups' => 'unit:collection'],
            extraProperties: ['militaryRankCode' => 'officer'],
            provider: UnitIndividualsProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/units/{id}/non-commissioned-officers',
            normalizationContext: ['groups' => 'unit:collection'],
            extraProperties: ['militaryRankCode' => 'non_commissioned_officer'],
            provider: UnitIndividualsProvider::class,
        ),  
        new GetCollection(
            uriTemplate: '/units/{id}/enlisted',
            normalizationContext: ['groups' => 'unit:collection'],
            extraProperties: ['militaryRankCode' => 'enlisted'],
            provider: UnitIndividualsProvider::class,
        ),
        new Get(
            normalizationContext: ['groups' => 'unit:read'],
        ),
        new Post( ),
        new Put(),
        new Delete(
            validate: true,
            validationContext: ['groups' => ['unit:delete']],
        )
    ],
    order: ['name' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['name'])]
#[PreventUnitDeletionIfHasIndividuals(groups: ['unit:delete'])]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['unit:read', 'unit:collection', 'individual:read', 'adminUnitPermission:collection', 'adminUnitPermission:read', 'admin:collection', 'admin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['unit:read', 'unit:collection', 'individual:read', 'adminUnitPermission:collection', 'adminUnitPermission:read', 'admin:collection', 'admin:read'])]
    private ?string $name = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['unit:read', 'unit:collection'])]
    private ?Individual $leader = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'unit')]
    #[Groups(['unit:read', 'unit:collection'])]
    private Collection $individuals;

    /**
     * @var Collection<int, AdminUnitPermission>
     */
    #[ORM\OneToMany(targetEntity: AdminUnitPermission::class, mappedBy: 'unit', cascade: ['remove'], orphanRemoval: true)]
    private Collection $adminUnitPermissions;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
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

    public function getLeader(): ?Individual
    {
        return $this->leader;
    }

    public function setLeader(?Individual $leader): static
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Collection<int, Individual>
     */
    public function getIndividuals(): Collection
    {
        return $this->individuals;
    }

    public function addIndividual(Individual $individual): static
    {
        if (!$this->individuals->contains($individual)) {
            $this->individuals->add($individual);
            $individual->setUnit($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getUnit() === $this) {
                $individual->setUnit(null);
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
            $adminUnitPermission->setUnit($this);
        }

        return $this;
    }

    public function removeAdminUnitPermission(AdminUnitPermission $adminUnitPermission): static
    {
        if ($this->adminUnitPermissions->removeElement($adminUnitPermission)) {
            // set the owning side to null (unless already changed)
            if ($adminUnitPermission->getUnit() === $this) {
                $adminUnitPermission->setUnit(null);
            }
        }

        return $this;
    }
}
