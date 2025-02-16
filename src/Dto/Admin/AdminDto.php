<?php

namespace App\Dto\Admin;

use App\Entity\Admin\Admin;

class AdminDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $username,
        public readonly ?string $image,
        public readonly array $globalPermissions,
        public readonly array $unitPermissions,
    ) {
    }

    public static function fromEntity(Admin $admin): self
    {
        return new self(
            $admin->getId(),
            $admin->getName(),
            $admin->getUsername(),
            $admin->getImage(),
            AdminGlobalPermissionDto::fromEntities($admin->getGlobalPermissions()),
            AdminUnitPermissionDto::fromEntities($admin->getUnitPermissions()),
        );
    }
}
