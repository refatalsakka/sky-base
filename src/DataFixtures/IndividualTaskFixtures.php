<?php

namespace App\DataFixtures;

use App\Entity\IndividualTask;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class IndividualTaskFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $individualTasks = Yaml::parseFile($this->folder . '/individualTasks.yaml')['individual_tasks'];

        foreach ($individualTasks as $individualTask) {
            $taskEntity = new IndividualTask();
            $taskEntity->setTask($individualTask);
            $manager->persist($taskEntity);
        }

        $manager->flush();

    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
