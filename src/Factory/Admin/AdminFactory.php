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
            'image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAAC0AQMAAAAHA5RxAAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAcklEQVRYhWNgGAXkgw8JBdiEGWckGGAXZ8AUN5c+fLDhgYENurhlX1piQ4JBGrq4wRke8wcJBoexiBsC1f/HIX4Aw/weNpD5yRju4WE+2Pijwg7DHAyX4xcfBaNgFIyCUTAKRsEoGAWjYBSMglEwCugHAJo1GlHYL8FWAAAAAElFTkSuQmCC',
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
