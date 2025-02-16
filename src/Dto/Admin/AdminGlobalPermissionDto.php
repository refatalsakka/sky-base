<?php

namespace App\Dto\Admin;

use App\Entity\Admin\AdminGlobalPermission;
use Doctrine\Common\Collections\Collection;

class AdminGlobalPermissionDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $adminId,
        public readonly string $username,
        public readonly int $roleId,
        public readonly string $roleName
    ) {
    }

    public static function fromEntity(AdminGlobalPermission $permission): self
    {
        return new self(
            $permission->getId(),
            $permission->getAdmin()->getId(),
            $permission->getAdmin()->getUsername(),
            $permission->getRole()->getId(),
            $permission->getRole()->getName(),
        );
    }

    public static function fromEntities(Collection $permissions): array
    {
        return array_map(fn(AdminGlobalPermission $permission) => self::fromEntity($permission), $permissions->toArray());
    }
}
