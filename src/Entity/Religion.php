<?php

namespace App\Entity;

use App\Entity\Individual;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReligionRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\IndividualRelationCountController;
use App\Controller\IndividualUnitRelationCountController;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\IndividualUnitMilitaryRankRelationCountController;

#[ORM\Entity(repositoryClass: ReligionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'religion:collection']),
        new Get(normalizationContext: ['groups' => 'religion:read']),
        new Get(
            uriTemplate: '/individual-religion/{key}/count',
            controller: IndividualRelationCountController::class,
            name: 'individual_religion_count',
            read: false,
            output: false,
        ),
        new Get(
            uriTemplate: '/individual-religion/{key}/unit/{unitId}/count',
            controller: IndividualUnitRelationCountController::class,
            name: 'individual_unit_religion_count',
            read: false,
            output: false,
        ),
        new Get(
            uriTemplate: '/individual-religion/{key}/unit/{unitId}/military-rank/{militaryRankId}/count',
            controller: IndividualUnitMilitaryRankRelationCountController::class,
            name: 'individual_unit_military_rank_religion_count',
            read: false,
            output: false,
        ),
    ],
    order: ['religion' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['religion'])]
class Religion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['religion:collection', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['religion:collection', 'religion:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?string $religion = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'religion')]
    private Collection $individuals;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReligion(): ?string
    {
        return $this->religion;
    }

    public function setReligion(string $religion): static
    {
        $this->religion = $religion;

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
            $individual->setReligion($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getReligion() === $this) {
                $individual->setReligion(null);
            }
        }

        return $this;
    }
}
