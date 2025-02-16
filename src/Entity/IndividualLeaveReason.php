<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\IndividualVacation;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\IndividualLeaveReasonRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: IndividualLeaveReasonRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'individualLeaveReason:collection']),
        new Get(normalizationContext: ['groups' => 'individualLeaveReason:read']),
    ],
    order: ['reason' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['reason'])]
class IndividualLeaveReason
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['individualLeaveReason:collection', 'individualLeaveReason:read', 'individual:collection', 'individual:read', 'individualVacation:collection', 'individualVacation:read', 'unit:read', 'unit:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individualLeaveReason:collection', 'individualLeaveReason:read', 'individual:collection', 'individual:read', 'individualVacation:collection', 'individualVacation:read', 'unit:read', 'unit:collection'])]
    private ?string $reason = null;

    /**
     * @var Collection<int, IndividualVacation>
     */
    #[ORM\OneToMany(targetEntity: IndividualVacation::class, mappedBy: 'reason')]
    private Collection $individualVacations;

    public function __construct()
    {
        $this->individualVacations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return Collection<int, IndividualVacation>
     */
    public function getIndividualVacations(): Collection
    {
        return $this->individualVacations;
    }

    public function addIndividualVacation(IndividualVacation $individualVacation): static
    {
        if (!$this->individualVacations->contains($individualVacation)) {
            $this->individualVacations->add($individualVacation);
            $individualVacation->setReason($this);
        }

        return $this;
    }

    public function removeIndividualVacation(IndividualVacation $individualVacation): static
    {
        if ($this->individualVacations->removeElement($individualVacation)) {
            // set the owning side to null (unless already changed)
            if ($individualVacation->getReason() === $this) {
                $individualVacation->setReason(null);
            }
        }

        return $this;
    }
}
