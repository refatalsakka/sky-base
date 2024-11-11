<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\IndividualTemporaryGuestRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndividualTemporaryGuestRepository::class)]
#[ApiResource(
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class IndividualTemporaryGuest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\Type('dateTime')]
    private ?\DateTimeInterface $departureDate = null;

    #[ORM\OneToOne(inversedBy: 'individualTemporaryGuest', cascade: ['persist', 'remove'])]
    private ?Individual $individual = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    private ?string $notice = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $originUnit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?\DateTimeInterface $departureDate): static
    {
        if ($this->departureDate !== null && $this->departureDate <= $this->arrivalDate) {
            throw new \InvalidArgumentException('The departure date must be after the arrival date.');
        }

        $this->departureDate = $departureDate;

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

    public function getNotice(): ?string
    {
        return $this->notice;
    }

    public function setNotice(?string $notice): static
    {
        $this->notice = $notice;

        return $this;
    }

    public function getOriginUnit(): ?string
    {
        return $this->originUnit;
    }

    public function setOriginUnit(string $originUnit): static
    {
        $this->originUnit = $originUnit;

        return $this;
    }
}
