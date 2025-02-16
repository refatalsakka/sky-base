<?php

namespace App\Security\Voter;

use App\Entity\Unit;
use App\Entity\Admin\Admin;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Admin\AdminUnitPermission;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class UnitVoter extends Voter
{
    public const VIEW_UNIT = 'ROLE_VIEW_UNIT';
    public const EDIT_UNIT = 'ROLE_EDIT_UNIT';
    public const DELETE_UNIT = 'ROLE_DELETE_UNIT';

    public const VIEW_OFFICERS = 'ROLE_VIEW_OFFICERS';
    public const VIEW_NCOS = 'ROLE_VIEW_NON_COMMISSIONED_OFFICERS';
    public const VIEW_ENLISTED = 'ROLE_VIEW_ENLISTED';

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [
                self::VIEW_UNIT,
                self::EDIT_UNIT,
                self::DELETE_UNIT,
                self::VIEW_OFFICERS,
                self::VIEW_NCOS,
                self::VIEW_ENLISTED
            ])
        ) {
            return false;
        }

        if ($subject instanceof Unit) {
            return true;
        }

        if (is_array($subject) && count($subject) === 1 && $subject[0] instanceof Unit) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var Admin */
        $user = $token->getUser();

        if (!$user instanceof Admin) {
            return false;
        }

        if (is_array($subject) && count($subject) === 1) {
            $subject = $subject[0];
        }

        if ($subject->getId() === null) {
            $request = $this->requestStack->getCurrentRequest();
            $unitId = $request->attributes->get('id');
            $subject = $this->entityManager->getRepository(Unit::class)->find($unitId);

            if (!$subject) {
                return false;
            }
        }

        switch ($attribute) {
            case self::VIEW_UNIT:
                return $this->canViewUnit($user, $subject);            
            case self::EDIT_UNIT:
                return $this->canEditUnit($user, $subject);            
            case self::DELETE_UNIT:
                return $this->canDeleteUnit($user, $subject);            
            case self::VIEW_OFFICERS:
                return $this->canViewOfficers($user, $subject);
            case self::VIEW_NCOS:
                return $this->canViewNcos($user, $subject);
            case self::VIEW_ENLISTED:
                return $this->canViewEnlisted($user, $subject);
        }

        return false;
    }

    private function canViewUnit(Admin $user, Unit $unit): bool
    {
        /** @var AdminUnitPermission */
        foreach ($user->getUnitPermissions() as $unitPermission) {
            if ($unitPermission->getUnit() === $unit && in_array($unitPermission->getRole()->getName(), [self::VIEW_UNIT])) {
                return true;
            }
        }

        return false;
    }

    private function canEditUnit(Admin $user, Unit $unit): bool
    {
        /** @var AdminUnitPermission */
        foreach ($user->getUnitPermissions() as $unitPermission) {
            if ($unitPermission->getUnit() === $unit && in_array($unitPermission->getRole()->getName(), [self::EDIT_UNIT])) {
                return true;
            }
        }
        return false;
    }

    private function canDeleteUnit(Admin $user, Unit $unit): bool
    {
        /** @var AdminUnitPermission */
        foreach ($user->getUnitPermissions() as $unitPermission) {
            if ($unitPermission->getUnit() === $unit && in_array($unitPermission->getRole()->getName(), [self::DELETE_UNIT])) {
                return true;
            }
        }

        return false;
    }

    private function canViewOfficers(Admin $user, Unit $unit): bool
    {
        /** @var AdminUnitPermission */
        foreach ($user->getUnitPermissions() as $unitPermission) {
            if ($unitPermission->getUnit() === $unit && in_array($unitPermission->getRole()->getName(), [self::VIEW_OFFICERS])) {
                return true;
            }
        }

        return false;
    }

    private function canViewNcos(Admin $user, Unit $unit): bool
    {
        /** @var AdminUnitPermission */
        foreach ($user->getUnitPermissions() as $unitPermission) {
            if ($unitPermission->getUnit() === $unit && in_array($unitPermission->getRole()->getName(), [self::VIEW_NCOS])) {
                return true;
            }
        }

        return false;
    }

    private function canViewEnlisted(Admin $user, Unit $unit): bool
    {
        /** @var AdminUnitPermission */
        foreach ($user->getUnitPermissions() as $unitPermission) {
            if ($unitPermission->getUnit() === $unit && in_array($unitPermission->getRole()->getName(), [self::VIEW_ENLISTED])) {
                return true;
            }
        }

        return false;
    }
}
