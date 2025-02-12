<?php

namespace App\Entity;

use App\Entity\Individual;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MilitaryRankRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MilitaryRankRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'militaryRank:collection']),
    ],
    order: ['rank' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['rank', 'code'])]
class MilitaryRank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['militaryRank:collection', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['militaryRank:collection', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?string $rank = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'militaryRank')]
    private Collection $individuals;

    /**
     * @var Collection<int, MilitarySubRank>
     */
    #[ORM\OneToMany(targetEntity: MilitarySubRank::class, mappedBy: 'militaryRank')]
    private Collection $subRanks;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $code = null;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
        $this->subRanks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(string $rank): static
    {
        $this->rank = $rank;

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
            $individual->setMilitaryRank($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getMilitaryRank() === $this) {
                $individual->setMilitaryRank(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MilitarySubRank>
     */
    public function getSubRanks(): Collection
    {
        return $this->subRanks;
    }

    public function addSubRank(MilitarySubRank $subRank): static
    {
        if (!$this->subRanks->contains($subRank)) {
            $this->subRanks->add($subRank);
            $subRank->setMilitaryRank($this);
        }

        return $this;
    }

    public function removeSubRank(MilitarySubRank $subRank): static
    {
        if ($this->subRanks->removeElement($subRank)) {
            // set the owning side to null (unless already changed)
            if ($subRank->getMilitaryRank() === $this) {
                $subRank->setMilitaryRank(null);
            }
        }

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
