<?php

namespace App\DataFixtures;

use App\Factory\IndividualFactory;
use App\DataFixtures\ReligionFixtures;
use App\DataFixtures\BloodTypeFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\MilitaryRankFixtures;
use App\DataFixtures\SocialStatusFixtures;
use App\DataFixtures\EducationLevelFixtures;
use App\DataFixtures\IndividualTaskFixtures;
use App\DataFixtures\Admin\AdminRoleFixtures;
use App\DataFixtures\IndividualStatusFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IndividualFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        IndividualFactory::createMany(20);
    }

    public function getDependencies(): array
    {
        return [
            BloodTypeFixtures::class,
            AdminRoleFixtures::class,
            MilitaryRankFixtures::class,
            IndividualStatusFixtures::class,
            IndividualTaskFixtures::class,
            SocialStatusFixtures::class,
            ReligionFixtures::class,
            EducationLevelFixtures::class,
            UnitFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
