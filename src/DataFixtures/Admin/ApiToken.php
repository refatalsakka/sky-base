<?php

namespace App\DataFixtures\Admin;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Factory\Admin\ApiTokenFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ApiToken extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ApiTokenFactory::createMany(5);
    }

    public function getDependencies(): array
    {
        return [
            AdminFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}