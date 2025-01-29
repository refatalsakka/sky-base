<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Base64Image extends Constraint
{
    public string $message = 'The string is not a valid base64-encoded image.';
}
