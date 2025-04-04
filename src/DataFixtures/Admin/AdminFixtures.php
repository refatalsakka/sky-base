<?php

namespace App\DataFixtures\Admin;

use App\DataFixtures\BaseFixture;
use App\Factory\Admin\AdminFactory;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        AdminFactory::createMany(5);
        AdminFactory::createOne([
            'username' => $_ENV['DEFAULT_ADMIN_USERNAME'],
        ]);
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
