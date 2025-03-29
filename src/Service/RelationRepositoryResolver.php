<?php

namespace App\Service;

use App\Repository\BloodTypeRepository;
use App\Repository\EducationLevelRepository;
use App\Repository\IndividualTaskRepository;
use App\Repository\IndividualStatusRepository;
use App\Repository\ReligionRepository;
use App\Repository\SocialStatusRepository;

class RelationRepositoryResolver
{
    public function __construct(
        private IndividualStatusRepository $individualStatusRepository,
        private IndividualTaskRepository $individualTaskRepository,
        private BloodTypeRepository $bloodTypeRepository,
        private EducationLevelRepository $educationLevelRepository,
        private ReligionRepository $religionRepository,
        private SocialStatusRepository $socialStatusRepository,
    ) {}

    public function resolve(string $route): array
    {
        return match ($route) {
            'individual_status_count' => [$this->individualStatusRepository, 'status'],
            'individual_task_count' => [$this->individualTaskRepository, 'task'],
            'individual_blood_type_count' => [$this->bloodTypeRepository, 'type'],
            'individual_educationL_level_count' => [$this->educationLevelRepository, 'level'],
            'individual_religion_count' => [$this->religionRepository, 'religion'],
            'individual_social_status_count' => [$this->socialStatusRepository, 'status'],
            default => throw new \InvalidArgumentException("Unsupported route: $route"),
        };
    }
}
