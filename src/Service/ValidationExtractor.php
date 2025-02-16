<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationExtractor
{
    // private const ALLOWED_FIELDS = ['type', 'min', 'max', 'message', 'allowNull'];

    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    public function getValidationRules(string $entityClass): array
    {
        $metadata = $this->validator->getMetadataFor($entityClass);
        $rules = [];

        foreach ($metadata->properties as $property => $constraints) {
            foreach ($constraints->constraints as $constraint) {
                $constraintData = [];

                $reflection = new \ReflectionClass($constraint);
                foreach ($reflection->getProperties() as $prop) {
                    $propName = $prop->getName();
                    if (property_exists($constraint, $propName) && $propName) {
                    // TODO: add condition
                    // if (property_exists($constraint, $propName) && in_array($propName, self::ALLOWED_FIELDS)) {
                        $constraintData[$propName] = $constraint->$propName;
                    }
                }

                $rules[$property][] = $constraintData;
            }
        }

        return $rules;
    }
}
