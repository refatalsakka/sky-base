<?php

namespace App\DataFixtures;

use App\Factory\IndividualTaskFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class IndividualTaskFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $individualTasks = Yaml::parseFile($this->folder . '/individualTasks.yaml')['individual_tasks'];

        foreach ($individualTasks as $individualTask) {
            IndividualTaskFactory::createOne(['task' => $individualTask]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
