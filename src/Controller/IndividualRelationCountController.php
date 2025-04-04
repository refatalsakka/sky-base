<?php

namespace App\Controller;

use App\Repository\IndividualRepository;
use App\Service\RelationRepositoryResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndividualRelationCountController extends AbstractController
{
    public function __invoke(
        string $key,
        Request $request,
        RelationRepositoryResolver $relationRepositoryResolver,
        IndividualRepository $individualRepository,
    ): JsonResponse
    {
        $route = $request->attributes->get('_route');

        [$relationRepository, $lookupField, $individualField] = $relationRepositoryResolver->resolve($route);

        $relationEntity = $relationRepository->findOneBy([$lookupField => $key]);

        if (!$relationEntity) {
            return new JsonResponse(['error' => "Item '$key' not found."], Response::HTTP_NOT_FOUND);
        }

        $count = $individualRepository->count([$individualField => $relationEntity]);

        return new JsonResponse(['key' => $key, 'count' => $count]);
    }
}
