<?php

namespace App\DataFixtures;

use App\Entity\Religion;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class ReligionFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $religions = Yaml::parseFile($this->folder . '/religions.yaml')['religions'];

        foreach ($religions as $religion) {
            $religionEntity = new Religion();
            $religionEntity->setReligion($religion);
            $manager->persist($religionEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
