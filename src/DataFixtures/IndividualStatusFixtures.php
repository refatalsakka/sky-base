<?php

namespace App\DataFixtures;

use App\Factory\IndividualStatusFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class IndividualStatusFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $individualStatuses = Yaml::parseFile($this->folder . '/individualStatuses.yaml')['individual_statuses'];

        foreach ($individualStatuses as $individualStatus) {
            IndividualStatusFactory::createOne(['status' => $individualStatus]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
