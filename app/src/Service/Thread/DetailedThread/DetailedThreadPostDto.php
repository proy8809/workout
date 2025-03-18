<?php

namespace App\Service\Thread\DetailedThread;

class DetailedThreadPostDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly DetailedThreadUserDto $user,
        public readonly string $createdAt,
    ) {

    }
}