<?php

namespace App\DataFixtures;

use Symfony\Component\Yaml\Yaml;
use App\Factory\MilitaryRankFactory;
use App\Factory\MilitarySubRankFactory;
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
            $militaryRankFactory = MilitaryRankFactory::createOne([
                'rank' => $militaryRank['name'],
                'code' => $militaryRank['code']
            ]);

            foreach($militaryRank['subs'] as $subRank) {
                MilitarySubRankFactory::createOne([
                    'subRank' => $subRank['name'],
                    'code' => $subRank['code'],
                    'militaryRank' => $militaryRankFactory
                ]);
            }
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'prod'];
    }
}
