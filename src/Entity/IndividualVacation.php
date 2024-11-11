<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\IndividualVacationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndividualVacationRepository::class)]
#[ApiResource(
    order: ['startDate' => 'ASC'],
    paginationEnabled: false,
)]
class IndividualVacation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('datetime')]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('datetime')]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'individualVacations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read'])]
    private ?IndividualLeaveReason $reason = null;

    #[ORM\ManyToOne(inversedBy: 'individualVacations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read'])]
    private ?Individual $individual = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getReason(): ?IndividualLeaveReason
    {
        return $this->reason;
    }

    public function setReason(?IndividualLeaveReason $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getIndividual(): ?Individual
    {
        return $this->individual;
    }

    public function setIndividual(?Individual $individual): static
    {
        $this->individual = $individual;

        return $this;
    }
}
