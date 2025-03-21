<?php

namespace App\Service\Shared;

class ResourceUserDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $fullName,
    ) {
    }
}