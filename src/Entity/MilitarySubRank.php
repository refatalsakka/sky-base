<?php

namespace App\Entity;

use App\Entity\Individual;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\MilitarySubRankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MilitarySubRankRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'militarySubRank:collection']),
    ],
    order: ['subRank' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['subRank', 'code'])]
class MilitarySubRank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['militarySubRank:collection', 'individual:read', 'unit:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['militarySubRank:collection', 'individual:read', 'unit:read'])]
    private ?string $subRank = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'militarySubRank')]
    private Collection $individuals;

    #[ORM\ManyToOne(inversedBy: 'subRanks')]
    private ?MilitaryRank $militaryRank = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $code = null;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubRank(): ?string
    {
        return $this->subRank;
    }

    public function setSubRank(string $subRank): static
    {
        $this->subRank = $subRank;

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
            $individual->setMilitarySubRank($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getMilitarySubRank() === $this) {
                $individual->setMilitarySubRank(null);
            }
        }

        return $this;
    }

    public function getMilitaryRank(): ?MilitaryRank
    {
        return $this->militaryRank;
    }

    public function setMilitaryRank(?MilitaryRank $militaryRank): static
    {
        $this->militaryRank = $militaryRank;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }
}
