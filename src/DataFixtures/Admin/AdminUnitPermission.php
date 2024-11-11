<?php

namespace App\DataFixtures\Admin;

use App\DataFixtures\UnitFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Factory\Admin\AdminUnitPermissionFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdminUnitPermission extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        AdminUnitPermissionFactory::createMany(20);
    }

    public function getDependencies(): array
    {
        return [
            AdminFixtures::class,
            AdminRoleFixtures::class,
            UnitFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}