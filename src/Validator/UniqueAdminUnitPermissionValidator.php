<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Admin\AdminUnitPermission;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueAdminUnitPermissionValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    { }

    public function validate(mixed $adminUnitPermission, Constraint $constraint): void
    {
        if (!$adminUnitPermission instanceof AdminUnitPermission) {
            return;
        }

        /** @var AdminUnitPermission */
        $existingPermission = $this->entityManager->getRepository(AdminUnitPermission::class)
            ->findOneBy([
                'unit' => $adminUnitPermission->getUnit(),
                'admin' => $adminUnitPermission->getAdmin(),
                'role' => $adminUnitPermission->getRole(),
            ]);

        if ($existingPermission) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
