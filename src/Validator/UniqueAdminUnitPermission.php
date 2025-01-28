<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class UniqueAdminUnitPermission extends Constraint
{
    public string $message = 'This permission already exists for the user.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
