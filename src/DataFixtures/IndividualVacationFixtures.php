<?php

namespace App\DataFixtures;

use App\Factory\IndividualVacationFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IndividualVacationFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        IndividualVacationFactory::createMany(10);
    }

    public function getDependencies(): array
    {
        return [
            IndividualFixtures::class,
            IndividualLeaveReasonFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
