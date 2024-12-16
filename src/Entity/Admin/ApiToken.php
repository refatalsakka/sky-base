<?php

namespace App\Entity\Admin;

use App\Repository\Admin\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApiTokenRepository::class)]
class ApiToken
{
    private const PERSONAL_ACCESS_TOKEN_PREFIX = 'tcp_';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'apiTokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Admin $ownedBy = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type('dateTime')]
    #[ORM\JoinColumn(nullable: true)]
    private ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column(length: 68)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private string $token;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotBlank()]
    #[Assert\Type('boolean')]
    private bool $valid = true;

    public function __construct(string $tokenType = self::PERSONAL_ACCESS_TOKEN_PREFIX)
    {
        $this->token = $tokenType.bin2hex(random_bytes(32));
        $this->expiresAt = new \DateTimeImmutable('+7 days');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnedBy(): ?Admin
    {
        return $this->ownedBy;
    }

    public function setOwnedBy(?Admin $ownedBy): static
    {
        $this->ownedBy = $ownedBy;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeImmutable $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function isValid(): bool
    {
        return $this->valid && $this->expiresAt === null || $this->expiresAt > new \DateTimeImmutable();
    }

    public function setValid(bool $valid): static
    {
        $this->valid = $valid;

        return $this;
    }
}
