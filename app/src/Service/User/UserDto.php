<?php

namespace App\Service\User;

class UserDto
{
    /**
     * @param list<string> $roles
     */
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly array $roles
    ) {
    }
}