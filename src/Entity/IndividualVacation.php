<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\IndividualVacationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndividualVacationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'individualVacation:collection']),
        new Get(normalizationContext: ['groups' => 'individualVacation:read']),
        new Post(),
        new Put(),
        new Delete()
    ],
    order: ['startDate' => 'ASC'],
    paginationEnabled: false,
)]
class IndividualVacation
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('datetime')]
    #[Groups(['individualVacation:collection', 'individualVacation:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('datetime')]
    #[Groups(['individualVacation:collection', 'individualVacation:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'individualVacations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individualVacation:collection', 'individualVacation:read', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?IndividualLeaveReason $reason = null;

    #[ORM\ManyToOne(inversedBy: 'individualVacations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individualVacation:collection', 'individualVacation:read'])]
    private ?Individual $individual = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['individualVacation:collection', 'individualVacation:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['individualVacation:collection', 'individualVacation:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

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
