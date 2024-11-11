<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

abstract class BaseFixture extends Fixture implements FixtureGroupInterface
{
    protected Generator $faker;

    protected string $folder;

    public function __construct()
    {
        $this->faker = Factory::create();

        $this->folder = __DIR__ . '/../../resources/dataFixtures';
    }
}
