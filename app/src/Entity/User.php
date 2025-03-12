<?php

namespace App\Entity;

use App\Enum\Role\Role;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private string $email;

    #[ORM\Column(length: 64)]
    private string $firstName;

    #[ORM\Column(length: 64)]
    private string $lastName;

    #[ORM\Column(length: 64)]
    private string $password;

    #[ORM\Column(enumType: Role::class)]
    private Role $role;

    #[ORM\OneToMany(
        targetEntity: Routine::class,
        mappedBy: "user",
        orphanRemoval: true
    )]
    private Collection $routines;

    public static function create(
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        Role $role
    ) {
        return new self(
            id: null,
            email: $email,
            firstName: $firstName,
            lastName: $lastName,
            password: $password,
            role: $role
        );
    }

    public function __construct(
        ?int $id = null,
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        Role $role
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->role = $role;

        $this->routines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function addRoutine(Routine $routine): void
    {
        $this->routines->add($routine);
    }

    public function removeRoutine(Routine $routine): void
    {
        $this->routines->removeElement($routine);
    }

    /**
     * @return Collection<int,Routine>
     */
    public function getRoutines(): Collection
    {
        return $this->routines;
    }
}
