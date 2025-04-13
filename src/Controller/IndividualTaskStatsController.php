<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IndividualTaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndividualTaskStatsController extends AbstractController
{
    public function __invoke(Request $request, IndividualTaskRepository $individualTaskRepository): JsonResponse
    {
        $unitId = $request->query->get('unitId');
        $militaryRankId = $request->query->get('militaryRankId');

        $results = $individualTaskRepository->findWithIndividualCount(
            $unitId ? (int) $unitId : null,
            $militaryRankId ? (int) $militaryRankId : null
        );

        return new JsonResponse($results);
    }
}
