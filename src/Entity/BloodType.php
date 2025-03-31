<?php

namespace App\Entity;

use App\Entity\Individual;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\BloodTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\IndividualRelationCountController;
use App\Controller\IndividualUnitRelationCountController;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\IndividualUnitMilitaryRankRelationCountController;

#[ORM\Entity(repositoryClass: BloodTypeRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'bloodType:collection']),
        new Get(normalizationContext: ['groups' => 'bloodType:read']),
        new Get(
            uriTemplate: '/individual-blood-type/{key}/count',
            controller: IndividualRelationCountController::class,
            name: 'individual_blood_type_count',
            read: false,
            output: false,
        ),
        new Get(
            uriTemplate: '/individual-blood-type/{key}/unit/{unitId}/count',
            controller: IndividualUnitRelationCountController::class,
            name: 'individual_unit_blood_type_count',
            read: false,
            output: false,
        ),
        new Get(
            uriTemplate: '/individual-blood-type/{key}/unit/{unitId}/military-rank/{militaryRankId}/count',
            controller: IndividualUnitMilitaryRankRelationCountController::class,
            name: 'individual_unit_military_rank_blood_type_count',
            read: false,
            output: false,
        ),
    ],
    order: ['type' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['type'])]
class BloodType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['bloodType:collection', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['bloodType:collection', 'bloodType:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?string $type = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'bloodType')]
    private Collection $individuals;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
            $individual->setBloodType($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getBloodType() === $this) {
                $individual->setBloodType(null);
            }
        }

        return $this;
    }
}
