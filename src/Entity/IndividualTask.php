<?php

namespace App\Entity;

use App\Entity\Individual;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\IndividualTaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Controller\IndividualTaskStatsController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: IndividualTaskRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => 'individualTask:collection']),
        new Get(normalizationContext: ['groups' => 'individualTask:read']),
        new GetCollection(
            uriTemplate: '/individual-tasks/stats',
            controller: IndividualTaskStatsController::class,
            name: 'individual_task_stats',
            normalizationContext: ['groups' => 'individualTask:collection'],
            read: false,
            output: false
        ),
        new Post(normalizationContext: ['groups' => 'individualTask:save']),
        new Patch(normalizationContext: ['groups' => 'individualTask:save']),
        new Delete(),
    ],
    order: ['task' => 'ASC'],
    paginationEnabled: false,
)]
#[UniqueEntity(fields: ['task'])]
class IndividualTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['individualTask:collection', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Groups(['individualTask:collection', 'individualTask:read', 'individualTask:save', 'individual:collection', 'individual:read', 'unit:read', 'unit:collection'])]
    private ?string $task = null;

    /**
     * @var Collection<int, Individual>
     */
    #[ORM\OneToMany(targetEntity: Individual::class, mappedBy: 'task')]
    private Collection $individuals;

    public function __construct()
    {
        $this->individuals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): static
    {
        $this->task = $task;

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
            $individual->setTask($this);
        }

        return $this;
    }

    public function removeIndividual(Individual $individual): static
    {
        if ($this->individuals->removeElement($individual)) {
            // set the owning side to null (unless already changed)
            if ($individual->getTask() === $this) {
                $individual->setTask(null);
            }
        }

        return $this;
    }
}
