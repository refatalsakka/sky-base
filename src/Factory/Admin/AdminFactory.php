<?php

namespace App\Factory\Admin;

use App\Entity\Admin\Admin;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends PersistentProxyObjectFactory<Admin>
 */
final class AdminFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public static function class(): string
    {
        return Admin::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->firstName('male') . ' ' . self::faker()->lastName('male'),
            'username' => self::faker()->username(255),
            'image' => self::faker()->imageUrl(640, 480, 'people')
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Admin $admin): void {
            $hashedPassword = $this->passwordHasher->hashPassword($admin, '12345');
            $admin->setPassword($hashedPassword);
        });
    }
}
