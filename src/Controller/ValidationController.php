<?php

namespace App\Controller;

use App\Entity\Admin\Admin;
use App\Entity\Admin\AdminRole;
use App\Entity\Admin\ApiToken;
use App\Entity\Individual;
use App\Entity\IndividualTemporaryDeployment;
use App\Entity\IndividualTemporaryGuest;
use App\Entity\IndividualVacation;
use App\Entity\Unit;
use App\Service\ValidationExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/validation-rules', methods: ['GET'])]
class ValidationController extends AbstractController
{

    public function __construct(
        private ValidationExtractor $validationExtractor
    ) {
    }

    #[Route('/admin')]
    public function getAdminValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(Admin::class));
    }

    #[Route('/admin-roles')]
    public function getAdminRolesValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(AdminRole::class));
    }

    #[Route('/admin-token')]
    public function getAdminTokenValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(ApiToken::class));
    }

    #[Route('/individual')]
    public function getIndividualValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(Individual::class));
    }

    #[Route('/individual-temporary-deployment')]
    public function getIndividualTemporaryDeploymentValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(IndividualTemporaryDeployment::class));
    }

    #[Route('/individual-temporary-guest')]
    public function getIndividualTemporaryGuestValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(IndividualTemporaryGuest::class));
    }

    #[Route('/individual-vacation')]
    public function getIndividualVacationValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(IndividualVacation::class));
    }

    #[Route('/unit')]
    public function getUnitValidationRules(): JsonResponse
    {
        return new JsonResponse($this->validationExtractor->getValidationRules(Unit::class));
    }
}
