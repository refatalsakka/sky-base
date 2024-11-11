<?php

namespace App\DataFixtures;

use App\Factory\BloodTypeFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class BloodTypeFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $bloodTypes = Yaml::parseFile($this->folder . '/bloodTypes.yaml')['blood_types'];

        foreach ($bloodTypes as $bloodType) {
            BloodTypeFactory::createOne(['type' => $bloodType]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
