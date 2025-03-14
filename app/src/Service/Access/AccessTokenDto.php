<?php

namespace App\Service\Access;

class AccessTokenDto
{
    public function __construct(
        public readonly string $token
    ) {
    }
}