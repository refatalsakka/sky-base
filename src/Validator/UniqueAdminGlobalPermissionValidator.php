<?php

namespace App\Validator;

use App\Entity\Admin\AdminGlobalPermission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueAdminGlobalPermissionValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    { }

    public function validate(mixed $adminGlobalPermission, Constraint $constraint): void
    {
        if (!$adminGlobalPermission instanceof AdminGlobalPermission) {
            return;
        }

        /** @var AdminGlobalPermission */
        $existingAdminGlobalPermission = $this->entityManager->getRepository(AdminGlobalPermission::class)
            ->findOneBy([
                'admin' => $adminGlobalPermission->getAdmin(),
                'role' => $adminGlobalPermission->getRole(),
            ]);

        if ($existingAdminGlobalPermission) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
