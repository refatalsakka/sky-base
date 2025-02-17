<?php

namespace App\DataFixtures;

use App\Entity\BloodType;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class BloodTypeFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $bloodTypes = Yaml::parseFile($this->folder . '/bloodTypes.yaml')['blood_types'];

        foreach ($bloodTypes as $bloodType) {
            $bloodTypeEntity = new BloodType();
            $bloodTypeEntity->setType($bloodType);
            $manager->persist($bloodTypeEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
