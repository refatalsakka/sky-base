<?php

namespace App\State;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Admin\Admin;
use App\Dto\ResetPasswordInput;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ResetPasswordProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Admin
    {
        if (!$data instanceof ResetPasswordInput) {
            throw new \InvalidArgumentException('Invalid input');
        }

        $admin = $this->entityManager->getRepository(Admin::class)->find($uriVariables['id']);

        if (!$admin) {
            throw new \RuntimeException('Admin not found');
        }

        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, $data->getNewPassword())
        );

        return $this->persistProcessor->process($admin, $operation, $uriVariables, $context);
    }
}
