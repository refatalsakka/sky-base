<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class Base64ImageValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Base64Image || !$value) {
            return;
        }

        if (!preg_match('/^data:image\/(png|jpeg|jpg|gif|webp);base64,/', $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        $base64String = substr($value, strpos($value, ',') + 1);

        if (base64_decode($base64String, true) === false) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
