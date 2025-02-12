<?php

namespace App\Provider;

use App\Entity\Unit;
use App\Entity\Individual;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IndividualRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnitIndividualsProvider implements ProviderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $unitId = $uriVariables['id'] ?? null;
        $militaryRankCode = $operation->getExtraProperties()['militaryRankCode'] ?? null;

        if (!$unitId || !$militaryRankCode) {
            throw new \InvalidArgumentException('Unit ID and Military Rank Code are required.');
        }

        /** @var Unit $unit */
        $unit = $this->entityManager->getRepository(Unit::class)->find($unitId);

        if (!$unit) {
            throw new NotFoundHttpException('Unit not found.');
        }

        /** @var IndividualRepository $repository */
        $repository = $this->entityManager->getRepository(Individual::class);

        return $repository->findByUnitAndMilitaryRank($unitId, $militaryRankCode);
    }
}
