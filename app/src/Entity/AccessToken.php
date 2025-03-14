<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AccessTokenRepository::class)]
#[ORM\Table(name: "access_tokens")]
class AccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ManyToOne(targetEntity: User::class, inversedBy: "accessTokens")]
    #[JoinColumn(name: "user_id", onDelete: "CASCADE")]
    private User $user;

    #[ORM\Column(length: 128)]
    private string $token;

    #[ORM\Column]
    private DateTimeImmutable $expiresAt;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->expiresAt = new DateTimeImmutable()->modify("+1 hour");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUser(UserInterface $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }
}