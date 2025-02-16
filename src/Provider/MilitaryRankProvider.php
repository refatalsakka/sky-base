<?php

namespace App\Provider;

use App\Entity\Individual;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\IndividualRepository;
use Doctrine\ORM\EntityManagerInterface;

class MilitaryRankProvider implements ProviderInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null
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
