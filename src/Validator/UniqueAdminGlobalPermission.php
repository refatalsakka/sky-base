<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class UniqueAdminGlobalPermission extends Constraint
{
    public string $message = 'This role already exists for the user.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
