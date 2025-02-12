<?php

namespace App\Entity;

use App\Entity\Individual;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\IndividualStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: IndividualStatusRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'individualStatus:collection']),
        new Get(normalizationContext: ['groups' => 'individualStatus:read']),
        new Post(),
        new Put(),
        new Delete()
    ],
    order: ['status' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['status'])]
class IndividualStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['individualStatus:collection', 'individualStatus:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individualStatus:collection', 'individualStatus:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?string $status = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'status')]
    private Collection $individuals;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
            $individual->setStatus($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getStatus() === $this) {
                $individual->setStatus(null);
            }
        }

        return $this;
    }
}
