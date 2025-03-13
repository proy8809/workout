<?php

namespace App\Service\User;

use App\Enum\Role;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDto
{
    /**
     * @param list<string> $roles
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email(message: "Email format is not valid")]
        #[Assert\Length(max: 64, maxMessage: "Email can't be more than 64 characters long")]
        public readonly string $email,

        #[Assert\NotBlank]
        #[Assert\Length(max: 64, maxMessage: "First name can't be more than 64 characters long")]
        public readonly string $firstName,

        #[Assert\NotBlank]
        #[Assert\Length(max: 64, maxMessage: "Last name can't be more than 64 characters long")]
        public readonly string $lastName,

        #[Assert\NotBlank]
        #[Assert\Length(min: 8, max: 64)]
        #[Assert\EqualTo(propertyPath: "passwordConfirmation", message: "Password confirmation is not equal to password")]
        public readonly string $password,

        #[Assert\NotBlank]
        #[Assert\Length(min: 8, max: 64)]
        #[Assert\EqualTo(propertyPath: "password", message: "Password confirmation is not equal to password")]
        public readonly string $passwordConfirmation,

        #[Assert\NotBlank(message: "Roles are empty")]
        #[Assert\All([
            new Assert\Choice(
                callback: [Role::class, "values"],
                message: "Invalid role {{ value }}."
            )
        ])]
        public readonly array $roles
    ) {
    }
}