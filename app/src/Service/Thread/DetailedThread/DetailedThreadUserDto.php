<?php

namespace App\Service\Thread\DetailedThread;

class DetailedThreadUserDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstName,
        public readonly string $lastName
    ) {
    }
}