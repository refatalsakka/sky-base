<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class PreventUnitDeletionIfHasIndividuals extends Constraint
{
    public string $message = 'You cannot delete this unit because it has associated individuals.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
