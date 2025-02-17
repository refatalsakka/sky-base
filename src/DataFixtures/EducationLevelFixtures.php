<?php

namespace App\DataFixtures;

use App\Entity\EducationLevel;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class EducationLevelFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $educationLevels = Yaml::parseFile($this->folder . '/educationLevel.yaml')['education_levels'];

        foreach ($educationLevels as $educationLevel) {
            $educationLevelEntity = new EducationLevel();
            $educationLevelEntity->setLevel($educationLevel);
            $manager->persist($educationLevelEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
