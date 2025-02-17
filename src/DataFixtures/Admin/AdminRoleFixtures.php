<?php

namespace App\DataFixtures\Admin;

use App\Entity\Admin\AdminRole;
use Symfony\Component\Yaml\Yaml;
use App\DataFixtures\BaseFixture;
use App\Enum\Admin\PermissionScope;
use App\Factory\Admin\AdminRoleFactory;
use Doctrine\Persistence\ObjectManager;

class AdminRoleFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $adminRoles = Yaml::parseFile($this->folder . '/adminRoles.yaml');

        foreach ($adminRoles['global'] as $taskName) {
            $role = new AdminRole();
            $role->setName($taskName);
            $role->setScope(PermissionScope::GLOBAL);
            $manager->persist($role);
        }

        foreach ($adminRoles['unit'] as $taskName) {
            $role = new AdminRole();
            $role->setName($taskName);
            $role->setScope(PermissionScope::UNIT);
            $manager->persist($role);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
