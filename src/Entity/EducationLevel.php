<?php

namespace App\Entity;

use App\Entity\Individual;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use App\Repository\EducationLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EducationLevelRepository::class)]
#[ApiResource(
    order: ['level' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['level'])]
class EducationLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection'])]
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
