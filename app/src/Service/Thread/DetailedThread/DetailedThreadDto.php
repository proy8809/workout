<?php

namespace App\Service\Thread\DetailedThread;

use App\Service\Post\PostDto;
use App\Service\Shared\ResourceUserDto;

class DetailedThreadDto
{
    /**
     * @param list<string> $tags
     * @param list<PostDto> $posts
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly array $tags,
        public readonly array $posts,
        public readonly ResourceUserDto $user,
        public readonly string $createdAt,
    ) {
    }
}