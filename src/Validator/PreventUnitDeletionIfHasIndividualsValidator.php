<?php

namespace App\Validator;

use App\Entity\Unit;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PreventUnitDeletionIfHasIndividualsValidator extends ConstraintValidator
{
    public function validate(mixed $unit, Constraint $constraint): void
    {
        if (!$unit instanceof Unit) {
            throw new UnexpectedTypeException($unit, Unit::class);
        }

        if ($unit->getIndividuals()->count() > 0) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
