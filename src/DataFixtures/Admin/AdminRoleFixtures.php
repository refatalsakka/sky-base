<?php

namespace App\DataFixtures\Admin;

use App\Enum\Admin\PermissionScope;
use Symfony\Component\Yaml\Yaml;
use App\DataFixtures\BaseFixture;
use App\Factory\Admin\AdminRoleFactory;
use Doctrine\Persistence\ObjectManager;

class AdminRoleFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $adminRoles = Yaml::parseFile($this->folder . '/adminRoles.yaml');

        foreach ($adminRoles['global'] as $taskName) {
            AdminRoleFactory::createOne([
                'name' => $taskName,
                'scope' => PermissionScope::GLOBAL,
            ]);
        }

        foreach ($adminRoles['unit'] as $taskName) {
            AdminRoleFactory::createOne([
                'name' => $taskName,
                'scope' => PermissionScope::UNIT,
            ]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
