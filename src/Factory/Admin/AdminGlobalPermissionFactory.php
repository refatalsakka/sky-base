<?php

namespace App\Factory\Admin;

use App\Enum\Admin\PermissionScope;
use App\Factory\Traits\RandomEntityTrait;
use App\Repository\Admin\AdminRepository;
use App\Entity\Admin\AdminGlobalPermissions;
use App\Repository\Admin\AdminRoleRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<AdminGlobalPermissions>
 */
final class AdminGlobalPermissionFactory extends PersistentProxyObjectFactory
{
    use RandomEntityTrait;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private AdminRepository $adminRepository,
        private AdminRoleRepository $adminRoleRepository,
    ) {
    }

    public static function class(): string
    {
        return AdminGlobalPermissions::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'admin' => $this->getRandomEntity($this->adminRepository),
            'role' => self::faker()->randomElement($this->adminRoleRepository->findBy(['scope' => PermissionScope::GLOBAL])),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(AdminGlobalPermissions $globalPermission): void {})
        ;
    }
}
