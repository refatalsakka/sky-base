<?php

namespace App\DataFixtures;

use App\Entity\SocialStatus;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class SocialStatusFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        $socialStatuses = Yaml::parseFile($this->folder . '/socialStatuses.yaml')['social_statuses'];

        foreach ($socialStatuses as $socialStatus) {
            $statusEntity = new SocialStatus();
            $statusEntity->setStatus($socialStatus);
            $manager->persist($statusEntity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
