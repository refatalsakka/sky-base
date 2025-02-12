<?php

namespace App\Dto\Admin;


use App\Entity\Admin\AdminUnitPermission;
use Doctrine\Common\Collections\Collection;

class AdminUnitPermissionDto
{
    public function __construct(
        public int $id,
        public int $adminId,
        public string $username,
        public int $roleId,
        public string $roleName,
        public int $unitId,
        public string $unitName
    ) {}

    public static function fromEntity(AdminUnitPermission $permission): self
    {
        return new self(
            $permission->getId(),
            $permission->getAdmin()->getId(),
            $permission->getAdmin()->getUsername(),
            $permission->getRole()->getId(),
            $permission->getRole()->getName(),
            $permission->getUnit()->getId(),
            $permission->getUnit()->getName(),
        );
    }

    public static function fromEntities(Collection $permissions): array
    {
        return array_map(fn(AdminUnitPermission $permission) => self::fromEntity($permission), $permissions->toArray());
    }
}
