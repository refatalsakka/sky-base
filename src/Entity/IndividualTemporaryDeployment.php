<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\IndividualTemporaryDeploymentRepository;

#[ORM\Entity(repositoryClass: IndividualTemporaryDeploymentRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    order: ['id' => 'ASC'],
    paginationEnabled: false,
)]
class IndividualTemporaryDeployment
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'individualTemporaryDeployment', cascade: ['persist', 'remove'])]
    private ?Individual $individual = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    private ?\DateTimeInterface $deploymentDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\Type('dateTime')]
    private ?\DateTimeInterface $returnDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    private ?string $notice = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $destinationUnit = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDeploymentDate(): ?\DateTimeInterface
    {
        return $this->deploymentDate;
    }

    public function setDeploymentDate(\DateTimeInterface $deploymentDate): static
    {
        $this->deploymentDate = $deploymentDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): static
    {
        if ($this->returnDate !== null && $this->returnDate <= $this->deploymentDate) {
            throw new \InvalidArgumentException('The return date must be after the deployment date.');
        }

        $this->returnDate = $returnDate;

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

    public function getDestinationUnit(): ?string
    {
        return $this->destinationUnit;
    }

    public function setDestinationUnit(string $destinationUnit): static
    {
        $this->destinationUnit = $destinationUnit;

        return $this;
    }
}
