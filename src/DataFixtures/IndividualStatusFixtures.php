<?php

namespace App\DataFixtures;

use App\Entity\IndividualStatus;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class IndividualStatusFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $individualStatuses = Yaml::parseFile($this->folder . '/individualStatuses.yaml')['individual_statuses'];

        foreach ($individualStatuses as $individualStatus) {
            $statusEntity = new IndividualStatus();
            $statusEntity->setStatus($individualStatus);
            $manager->persist($statusEntity);
        }

        $manager->flush();    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
