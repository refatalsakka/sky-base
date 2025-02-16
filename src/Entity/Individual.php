<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\IndividualVacation;
use ApiPlatform\Metadata\ApiResource;
use App\Provider\MilitaryRankProvider;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\IndividualRepository;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndividualRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/individuals',
            normalizationContext: ['groups' => 'individual:collection'],
        ),
        new GetCollection(
            uriTemplate: '/individuals/officers',
            normalizationContext: ['groups' => 'individual:collection'],
            provider: MilitaryRankProvider::class,
            extraProperties: ['militaryRankCode' => 'officer']
        ),
        new GetCollection(
            uriTemplate: '/individuals/non-commissioned-officers',
            normalizationContext: ['groups' => 'individual:collection'],
            provider: MilitaryRankProvider::class,
            extraProperties: ['militaryRankCode' => 'non_commissioned_officer']
        ),
        new GetCollection(
            uriTemplate: '/individuals/enlisted',
            normalizationContext: ['groups' => 'individual:collection'],
            provider: MilitaryRankProvider::class,
            extraProperties: ['militaryRankCode' => 'enlisted']
        ),
        new Get(normalizationContext: ['groups' => 'individual:read']),
        new Post(),
        new Put(),
        new Delete()
    ],
    order: ['id' => 'ASC'],
    forceEager: false,
    paginationEnabled: false,
)]
class Individual
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection', 'vacation:collection', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?MilitaryRank $militaryRank = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?MilitarySubRank $militarySubRank = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection', 'vacation:collection', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?string $militaryId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?\DateTimeInterface $registerDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?IndividualStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?IndividualTask $task = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?string $nationalId = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?string $placeOfBirth = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?\DateTimeInterface $joinDate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?string $specialization = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection', 'individualVacation:collection', 'individualVacation:read'])]
    private ?string $mobileNumber = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?string $profession = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?SocialStatus $socialStatus = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?BloodType $bloodType = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?Religion $religion = null;

    #[ORM\Column(name: 'is_father_alive', type: 'boolean')]
    #[Assert\Type('boolean')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?bool $fatherAlive = null;

    #[ORM\Column(name: 'is_mother_alive', type: 'boolean')]
    #[Assert\Type('boolean')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?bool $motherAlive = null;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['individual:read', 'individual:collection'])]
    private ?EducationLevel $educationLevel = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type('int')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?int $detentionTimes = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type('int')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?int $imprisonmentTimes = null;

    /**
     * @var Collection<int, IndividualVacation>
     */
    #[ORM\OneToMany(targetEntity: IndividualVacation::class, mappedBy: 'individual')]
    #[Assert\NotBlank()]
    #[Groups(['individual:read'])]
    private Collection $individualVacations;

    #[ORM\ManyToOne(inversedBy: 'individuals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    #[Groups(['individual:read'])]
    private ?Unit $unit = null;

    #[ORM\Column(type: 'blob')]
    #[Assert\NotBlank()]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private mixed $image = null;

    #[ORM\OneToOne(mappedBy: 'individual', cascade: ['persist', 'remove'])]
    private ?IndividualTemporaryGuest $individualTemporaryGuest = null;

    #[ORM\OneToOne(mappedBy: 'individual', cascade: ['persist', 'remove'])]
    private ?IndividualTemporaryDeployment $individualTemporaryDeployment = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['individual:read', 'individual:collection', 'unit:read', 'unit:collection'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->individualVacations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMilitarySubRank(): ?MilitarySubRank
    {
        return $this->militarySubRank;
    }

    public function setMilitarySubRank(?MilitarySubRank $militarySubRank): static
    {
        if (!$this->militaryRank->getSubRanks()->contains($militarySubRank)) {
            throw new \InvalidArgumentException('The provided military sub-rank is not valid for the given military rank.');
        }

        $this->militarySubRank = $militarySubRank;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMilitaryId(): ?string
    {
        return $this->militaryId;
    }

    public function setMilitaryId(string $militaryId): static
    {
        $this->militaryId = $militaryId;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): static
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getStatus(): ?IndividualStatus
    {
        return $this->status;
    }

    public function setStatus(?IndividualStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTask(): ?IndividualTask
    {
        return $this->task;
    }

    public function setTask(?IndividualTask $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getNationalId(): ?string
    {
        return $this->nationalId;
    }

    public function setNationalId(string $nationalId): static
    {
        $this->nationalId = $nationalId;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(string $placeOfBirth): static
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getJoinDate(): ?\DateTimeInterface
    {
        return $this->joinDate;
    }

    public function setJoinDate(\DateTimeInterface $joinDate): static
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): static
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(string $mobileNumber): static
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getSocialStatus(): ?SocialStatus
    {
        return $this->socialStatus;
    }

    public function setSocialStatus(?SocialStatus $socialStatus): static
    {
        $this->socialStatus = $socialStatus;

        return $this;
    }

    public function getBloodType(): ?BloodType
    {
        return $this->bloodType;
    }

    public function setBloodType(?BloodType $bloodType): static
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getReligion(): ?Religion
    {
        return $this->religion;
    }

    public function setReligion(?Religion $religion): static
    {
        $this->religion = $religion;

        return $this;
    }

    public function isFatherAlive(): ?bool
    {
        return $this->fatherAlive;
    }

    public function setFatherAlive(bool $isFatherAlive): static
    {
        $this->fatherAlive = $isFatherAlive;

        return $this;
    }

    public function isMotherAlive(): ?bool
    {
        return $this->motherAlive;
    }

    public function setMotherAlive(bool $isMotherAlive): static
    {
        $this->motherAlive = $isMotherAlive;

        return $this;
    }

    public function getEducationLevel(): ?EducationLevel
    {
        return $this->educationLevel;
    }

    public function setEducationLevel(?EducationLevel $educationLevel): static
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    public function getDetentionTimes(): ?int
    {
        return $this->detentionTimes;
    }

    public function setDetentionTimes(int $detentionTimes): static
    {
        $this->detentionTimes = $detentionTimes;

        return $this;
    }

    public function getImprisonmentTimes(): ?int
    {
        return $this->imprisonmentTimes;
    }

    public function setImprisonmentTimes(int $imprisonmentTimes): static
    {
        $this->imprisonmentTimes = $imprisonmentTimes;

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
            $individualVacation->setIndividual($this);
        }

        return $this;
    }

    public function removeIndividualVacation(IndividualVacation $individualVacation): static
    {
        if ($this->individualVacations->removeElement($individualVacation)) {
            // set the owning side to null (unless already changed)
            if ($individualVacation->getIndividual() === $this) {
                $individualVacation->setIndividual(null);
            }
        }

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getImage(): ?string
    {
        if (is_resource($this->image)) {
            return stream_get_contents($this->image);
        }

        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getIndividualTemporaryGuest(): ?IndividualTemporaryGuest
    {
        return $this->individualTemporaryGuest;
    }

    public function setIndividualTemporaryGuest(?IndividualTemporaryGuest $individualTemporaryGuest): static
    {
        // unset the owning side of the relation if necessary
        if ($individualTemporaryGuest === null && $this->individualTemporaryGuest !== null) {
            $this->individualTemporaryGuest->setIndividual(null);
        }

        // set the owning side of the relation if necessary
        if ($individualTemporaryGuest !== null && $individualTemporaryGuest->getIndividual() !== $this) {
            $individualTemporaryGuest->setIndividual($this);
        }

        $this->individualTemporaryGuest = $individualTemporaryGuest;

        return $this;
    }

    public function getIndividualTemporaryDeployment(): ?IndividualTemporaryDeployment
    {
        return $this->individualTemporaryDeployment;
    }

    public function setIndividualTemporaryDeployment(?IndividualTemporaryDeployment $individualTemporaryDeployment): static
    {
        // unset the owning side of the relation if necessary
        if ($individualTemporaryDeployment === null && $this->individualTemporaryDeployment !== null) {
            $this->individualTemporaryDeployment->setIndividual(null);
        }

        // set the owning side of the relation if necessary
        if ($individualTemporaryDeployment !== null && $individualTemporaryDeployment->getIndividual() !== $this) {
            $individualTemporaryDeployment->setIndividual($this);
        }

        $this->individualTemporaryDeployment = $individualTemporaryDeployment;

        return $this;
    }
}
