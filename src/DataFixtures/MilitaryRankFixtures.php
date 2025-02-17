<?php

namespace App\DataFixtures;

use App\Entity\MilitaryRank;
use App\Entity\MilitarySubRank;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Persistence\ObjectManager;

class MilitaryRankFixtures extends BaseFixture
{
    public function load(ObjectManager $manager): void
    {
        [
            'officer' => $officer,
            'non_commissioned_officer' => $nonCommissionedOfficer,
            'enlisted' => $enlisted
        ] = Yaml::parseFile($this->folder . '/militaryRanks.yaml');

        foreach ([
                $officer,
                $nonCommissionedOfficer,
                $enlisted
            ] as $militaryRank
        ) {
            $militaryRankEntity = new MilitaryRank();
            $militaryRankEntity->setRank($militaryRank['name']);
            $militaryRankEntity->setCode($militaryRank['code']);

            $manager->persist($militaryRankEntity);

            foreach ($militaryRank['subs'] as $militarySubRank) {
                $militarySubRankEntity = new MilitarySubRank();
                $militarySubRankEntity->setSubRank($militarySubRank['name']);
                $militarySubRankEntity->setCode($militarySubRank['code']);
                $militarySubRankEntity->setMilitaryRank($militaryRankEntity);

                $manager->persist($militarySubRankEntity);
            }

            $manager->flush();
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
