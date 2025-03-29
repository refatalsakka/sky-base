<?php

namespace App\Controller;

use App\Repository\IndividualRepository;
use App\Service\RelationRepositoryResolver;
use App\Repository\IndividualTaskRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\IndividualStatusRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
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

        [$repository, $filed] = $relationRepositoryResolver->resolve($route);

        $entity = $repository->findOneBy([$filed => $key]);

        if (!$entity) {
            return new JsonResponse(['error' => "Item '$key' not found."], Response::HTTP_NOT_FOUND);
        }

        $count = $individualRepository->count([$filed => $entity]);

        return new JsonResponse(['key' => $key, 'count' => $count]);
    }
}
