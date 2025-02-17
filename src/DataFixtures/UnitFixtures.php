<?php

namespace App\DataFixtures;

use App\Factory\UnitFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $militaryUnitNames = Yaml::parseFile($this->folder . '/militaryUnitNames.yaml')['military_units'];

        for ($i = 0; $i < count($militaryUnitNames); $i++) {
            UnitFactory::createOne([
                'leader' => null,
                'name' => $militaryUnitNames[$i],
            ]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
