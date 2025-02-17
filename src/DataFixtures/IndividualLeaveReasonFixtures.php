<?php

namespace App\DataFixtures;

use Symfony\Component\Yaml\Yaml;
use App\Entity\IndividualLeaveReason;
use Doctrine\Persistence\ObjectManager;

class IndividualLeaveReasonFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $leaveReasons = Yaml::parseFile($this->folder . '/individualLeaveReasons.yaml')['individual_leave_reasons'];

        foreach ($leaveReasons as $leaveReason) {
            $leaveReasonEntity = new IndividualLeaveReason();
            $leaveReasonEntity->setReason($leaveReason);
            $manager->persist($leaveReasonEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
