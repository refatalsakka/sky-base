<?php

namespace App\DataFixtures;

use App\Repository\UnitRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\IndividualRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AssignLeaderToUnitFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function __construct(
        private UnitRepository $unitRepository,
        private IndividualRepository $individualRepository
    ) {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $units = $this->unitRepository->findAll();
        $individuals = $this->individualRepository->findAll();

        foreach ($units as $unit) {
            $individual = $this->faker->randomElement($individuals);
            $unit->setLeader($individual);

            $manager->persist($unit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UnitFixtures::class,
            IndividualFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
