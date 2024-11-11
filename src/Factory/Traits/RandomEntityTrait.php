<?php

namespace App\Factory\Traits;

use Doctrine\Persistence\ObjectRepository;

trait RandomEntityTrait
{
    private function getRandomEntity(ObjectRepository $repository): mixed
    {
        $entities = $repository->findAll();
        if (empty($entities)) {
            throw new \RuntimeException('No entities in ' . $repository->getClassName() . ' were found');
        }

        return self::faker()->randomElement($entities);
    }
}
