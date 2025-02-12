<?php

namespace App\Dto\Admin;

use App\Entity\Admin\Admin;

class AdminDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $username,
        public ?string $image,
        public array $globalPermissions,
        public array $unitPermissions,
    ) {}

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
