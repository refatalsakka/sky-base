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
    private array $routeMap = [
        'individual_status_count' => 'status',
        'individual_unit_status_count' => 'status',
        'individual_unit_military_rank_status_count' => 'status',

        'individual_task_count' => 'task',
        'individual_unit_task_count' => 'task',
        'individual_unit_military_rank_task_count' => 'task',

        'individual_blood_type_count' => 'bloodType',
        'individual_unit_blood_type_count' => 'bloodType',
        'individual_unit_military_rank_blood_type_count' => 'bloodType',

        'individual_educationL_level_count' => 'educationLevel',
        'individual_unit_educationL_level_count' => 'educationLevel',
        'individual_unit_military_rank_educationL_level_count' => 'educationLevel',

        'individual_religion_count' => 'religion',
        'individual_unit_religion_count' => 'religion',
        'individual_unit_military_rank_religion_count' => 'religion',

        'individual_social_status_count' => 'socialStatus',
        'individual_unit_social_status_count' => 'socialStatus',
        'individual_unit_military_rank_social_status_count' => 'socialStatus',
    ];

    private array $configMap = [];

    public function __construct(
        private IndividualStatusRepository $individualStatusRepository,
        private IndividualTaskRepository $individualTaskRepository,
        private BloodTypeRepository $bloodTypeRepository,
        private EducationLevelRepository $educationLevelRepository,
        private ReligionRepository $religionRepository,
        private SocialStatusRepository $socialStatusRepository,
    ) {
        $this->configMap = [
            'status' => [$this->individualStatusRepository, 'status'],
            'task' => [$this->individualTaskRepository, 'task'],
            'bloodType' => [$this->bloodTypeRepository, 'type'],
            'educationLevel' => [$this->educationLevelRepository, 'level'],
            'religion' => [$this->religionRepository, 'religion'],
            'socialStatus' => [$this->socialStatusRepository, 'status'],
        ];
    }

    public function resolve(string $route): array
    {
        $individualField = $this->routeMap[$route] ?? null;

        if (!$individualField || !isset($this->configMap[$individualField])) {
            throw new \InvalidArgumentException("Unsupported route: $route");
        }
    
        [$repository, $lookupField] = $this->configMap[$individualField];
    
        return [$repository, $lookupField, $individualField];
    }
}
