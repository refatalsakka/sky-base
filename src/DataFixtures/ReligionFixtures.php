<?php

namespace App\DataFixtures;

use App\Factory\ReligionFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class ReligionFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $religions = Yaml::parseFile($this->folder . '/religions.yaml')['religions'];

        foreach ($religions as $religion) {
            ReligionFactory::createOne(['religion' => $religion]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
