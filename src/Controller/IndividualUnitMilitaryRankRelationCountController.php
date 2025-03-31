<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Entity\MilitaryRank;
use App\Repository\UnitRepository;
use App\Repository\IndividualRepository;
use App\Repository\MilitaryRankRepository;
use App\Service\RelationRepositoryResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndividualUnitMilitaryRankRelationCountController extends AbstractController
{
    public function __invoke(
        string $key,
        string $unitId,
        string $militaryRankId,
        Request $request,
        RelationRepositoryResolver $relationRepositoryResolver,
        IndividualRepository $individualRepository,
        UnitRepository $unitRepository,
        MilitaryRankRepository $militaryRankRepository,
    ): JsonResponse 
    {
        /** @var Unit */
        $unitEntity = $unitRepository->find($unitId);

        if (!$unitEntity) {
            return new JsonResponse(['error' => "Unit '$unitId' not found."], Response::HTTP_NOT_FOUND);
        }

        /** @var MilitaryRank */
        $militaryRankEntity = $militaryRankRepository->find($militaryRankId);

        if (!$militaryRankEntity) {
            return new JsonResponse(['error' => "Military Rank '$militaryRankId' not found."], Response::HTTP_NOT_FOUND);
        }

        $route = $request->attributes->get('_route');

        [$relationRepository, $lookupField, $individualField] = $relationRepositoryResolver->resolve($route);

        $relationEntity = $relationRepository->findOneBy([$lookupField => $key]);

        if (!$relationEntity) {
            return new JsonResponse(['error' => "Item '$key' not found."], Response::HTTP_NOT_FOUND);
        }

        $count = $individualRepository->count([$individualField => $relationEntity, 'unit' => $unitEntity, 'militaryRank' => $militaryRankEntity]);

        return new JsonResponse(['key' => $key, 'unit' => $unitEntity->getName(), 'militaryRank' => $militaryRankEntity->getRank(), 'count' => $count]);
    }
}
