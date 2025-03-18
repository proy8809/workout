<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $password;

    /**
     * @var list<string>
     */
    #[ORM\Column]
    private array $roles;

    #[OneToMany(
        targetEntity: AccessToken::class,
        mappedBy: "user",
        cascade: ["persist"],
        orphanRemoval: true
    )]
    private Collection $accessTokens;

    public function __construct(
        #[ORM\Column(length: 128)]
        private string $email,

        #[ORM\Column(length: 64)]
        private string $firstName,

        #[ORM\Column(length: 64)]
        private string $lastName,
    ) {
        $this->roles = ["ROLE_USER"];
        $this->accessTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return list<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasActiveAccessToken(): bool
    {
        return $this->accessTokens->exists(
            fn(int $key, AccessToken $accessToken) => $accessToken->isExpired() === false
        );
    }

    public function addAccessToken(string $value): static
    {
        $accessToken = new AccessToken($this, $value);

        if (!$this->accessTokens->contains($accessToken)) {
            $this->accessTokens->add($accessToken);
        }

        return $this;
    }

    public function clearAccessTokens(): static
    {
        $this->accessTokens = new ArrayCollection([]);

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
