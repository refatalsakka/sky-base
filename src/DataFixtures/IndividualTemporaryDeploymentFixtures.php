<?php

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\IndividualRepository;
use App\Factory\IndividualTemporaryDeploymentFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IndividualTemporaryDeploymentFixtures  extends BaseFixture implements DependentFixtureInterface
{
    public function __construct(
        private IndividualRepository $individualRepository
    ) {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        $individuals = $this->individualRepository->findBy([], null, 3);

        foreach ($individuals as $individual) {
            IndividualTemporaryDeploymentFactory::createOne([
                'individual' => $individual
            ]);
        }
    }

    public function getDependencies(): array
    {
        return [
            IndividualFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
