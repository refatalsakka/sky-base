<?php

namespace App\Entity;

use App\Entity\Individual;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\EducationLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\IndividualRelationCountController;
use App\Controller\IndividualUnitRelationCountController;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\IndividualUnitMilitaryRankRelationCountController;

#[ORM\Entity(repositoryClass: EducationLevelRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'educationLevel:collection']),
        new Get(normalizationContext: ['groups' => 'educationLevel:read']),
        new Get(
            uriTemplate: '/individual-education-level/{key}/count',
            controller: IndividualRelationCountController::class,
            name: 'individual_educationL_level_count',
            read: false,
            output: false,
        ),
        new Get(
            uriTemplate: '/individual-education-level/{key}/unit/{unitId}/count',
            controller: IndividualUnitRelationCountController::class,
            name: 'individual_unit_educationL_level_count',
            read: false,
            output: false,
        ),
        new Get(
            uriTemplate: '/individual-education-level/{key}/unit/{unitId}/military-rank/{militaryRankId}/count',
            controller: IndividualUnitMilitaryRankRelationCountController::class,
            name: 'individual_unit_military_rank_educationL_level_count',
            read: false,
            output: false,
        ),
    ],
    order: ['level' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['level'])]
class EducationLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['educationLevel:collection', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['educationLevel:collection', 'educationLevel:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?string $level = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'educationLevel')]
    private Collection $individuals;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

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
            $individual->setEducationLevel($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getEducationLevel() === $this) {
                $individual->setEducationLevel(null);
            }
        }

        return $this;
    }
}
