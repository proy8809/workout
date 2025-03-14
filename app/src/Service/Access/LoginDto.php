<?php

namespace App\Service\Access;

class LoginDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}