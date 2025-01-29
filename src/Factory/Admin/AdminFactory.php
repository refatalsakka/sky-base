<?php

namespace App\Factory\Admin;

use App\Entity\Admin\Admin;
use App\Factory\Util\ImageGeneratorTrait;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends PersistentProxyObjectFactory<Admin>
 */
final class AdminFactory extends PersistentProxyObjectFactory
{
    use ImageGeneratorTrait;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
            private UserPasswordHasherInterface $passwordHasher,
            private string $defaultPassword
        ) {
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
            'image' => $this->generateBase64Image('Profile Picture')
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Admin $admin): void {
            $hashedPassword = $this->passwordHasher->hashPassword($admin, $this->defaultPassword);
            $admin->setPassword($hashedPassword);
        });
    }
}
