<?php

namespace App\DataFixtures;

use App\Factory\SocialStatusFactory;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class SocialStatusFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $socialStatuses = Yaml::parseFile($this->folder . '/socialStatuses.yaml')['social_statuses'];

        foreach ($socialStatuses as $socialStatus) {
            SocialStatusFactory::createOne(['status' => $socialStatus]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
