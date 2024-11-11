<?php

namespace App\DataFixtures\Admin;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Factory\Admin\AdminGlobalPermissionFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdminGlobalPermissionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        AdminGlobalPermissionFactory::createMany(50);
    }

    public function getDependencies(): array
    {
        return [
            AdminFixtures::class,
            AdminRoleFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
