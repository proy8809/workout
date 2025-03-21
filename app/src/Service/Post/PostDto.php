<?php

namespace App\Service\Post;

use App\Service\Shared\ResourceUserDto;

class PostDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly ResourceUserDto $user,
        public readonly string $createdAt,
    ) {
    }
}