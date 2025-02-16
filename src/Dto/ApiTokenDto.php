<?php

namespace App\Dto;

use App\Entity\Admin\ApiToken;

class ApiTokenDto
{
    public function __construct(
        public readonly string $token,
        public readonly \DateTimeImmutable $expires_at,
        public readonly string $type,
    ) {
    }

    public static function fromEntity(ApiToken $apiToken, $type): self
    {
        return new self(
            $apiToken->getToken(),
            $apiToken->getExpiresAt(),
            $type,
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'expires_at' => $this->expires_at,
            'type' => $this->type,
        ];
    }
}
