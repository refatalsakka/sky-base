<?php

namespace App\Factory\Admin;

use App\Repository\UnitRepository;
use App\Enum\Admin\PermissionScope;
use App\Entity\Admin\AdminUnitPermission;
use App\Factory\UnitFactory;
use App\Repository\Admin\AdminRepository;
use App\Repository\Admin\AdminRoleRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<AdminUnitPermission>
 */
final class AdminUnitPermissionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private AdminRepository $adminRepository,
        private AdminRoleRepository $adminRoleRepository,
        private UnitRepository $unitRepository,
    ) {
    }

    public static function class(): string
    {
        return AdminUnitPermission::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'admin' => AdminFactory::random(),
            'role' => self::faker()->randomElement($this->adminRoleRepository->findBy(['scope' => PermissionScope::UNIT])),
            'unit' => UnitFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(AdminUnitPermission $adminUnitPermission): void {})
        ;
    }
}
