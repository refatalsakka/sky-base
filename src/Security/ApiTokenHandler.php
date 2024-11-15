<?php

namespace App\Security;

use SensitiveParameter;
use Psr\Log\LoggerInterface;
use App\Entity\Admin\ApiToken;
use App\Repository\Admin\ApiTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ApiTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private ApiTokenRepository $apiTokenRepository,
        private LoggerInterface $logger
    ) {
    }

    public function getUserBadgeFrom(#[SensitiveParameter] string $accessToken): UserBadge
    {
        $this->logger->info('Validating access token', ['token' => $accessToken]);

        /** @var ApiToken */
        $token = $this->apiTokenRepository->findOneBy(['token' => $accessToken]);

        if (!$token) {
            throw new BadCredentialsException('Invalid token provided.');
        }

        if (!$token->isValid()) {
            throw new CustomUserMessageAuthenticationException('The token is not valid');
        }

        return new UserBadge($token->getOwnedBy()->getUserIdentifier());
    }
}