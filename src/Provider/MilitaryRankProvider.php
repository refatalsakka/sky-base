<?php

namespace App\Provider;

use App\Entity\Individual;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\IndividualRepository;
use Doctrine\ORM\EntityManagerInterface;

class MilitaryRankProvider implements ProviderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $militaryRankCode = $operation->getExtraProperties()['militaryRankCode'] ?? null;

        if (!$militaryRankCode) {
            throw new \InvalidArgumentException('Military rank code is required.');
        }

        /** @var IndividualRepository $repository */
        $repository = $this->entityManager->getRepository(Individual::class);

        return $repository->findByMilitaryRankCode($militaryRankCode);
    }
}
