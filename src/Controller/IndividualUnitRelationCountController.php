<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Repository\UnitRepository;
use App\Repository\IndividualRepository;
use App\Service\RelationRepositoryResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndividualUnitRelationCountController extends AbstractController
{
    public function __invoke(
        string $key,
        string $unitId,
        Request $request,
        RelationRepositoryResolver $relationRepositoryResolver,
        IndividualRepository $individualRepository,
        UnitRepository $unitRepository,
    ): JsonResponse 
    {
        /** @var Unit */
        $unitEntity = $unitRepository->find($unitId);

        if (!$unitEntity) {
            return new JsonResponse(['error' => "Unit '$unitId' not found."], Response::HTTP_NOT_FOUND);
        }

        $route = $request->attributes->get('_route');

        [$relationRepository, $lookupField, $individualField] = $relationRepositoryResolver->resolve($route);

        $relationEntity = $relationRepository->findOneBy([$lookupField => $key]);

        if (!$relationEntity) {
            return new JsonResponse(['error' => "Item '$key' not found."], Response::HTTP_NOT_FOUND);
        }

        $count = $individualRepository->count([$individualField => $relationEntity, 'unit' => $unitEntity]);

        return new JsonResponse(['key' => $key, 'unit' => $unitEntity->getName(), 'count' => $count]);
    }
}
