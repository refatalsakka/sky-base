<?php

namespace App\DataFixtures;

use App\Factory\IndividualLeaveReasonFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class IndividualLeaveReasonFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $leaveReasons = Yaml::parseFile($this->folder . '/individualLeaveReasons.yaml')['individual_leave_reasons'];

        foreach ($leaveReasons as $leaveReason) {
            IndividualLeaveReasonFactory::createOne(['reason' => $leaveReason]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
