<?php

namespace App\DataFixtures;

use App\Factory\EducationLevelFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class EducationLevelFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $educationLevels = Yaml::parseFile($this->folder . '/educationLevel.yaml')['education_levels'];

        foreach ($educationLevels as $educationLevel) {
            EducationLevelFactory::createOne(['level' => $educationLevel]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
