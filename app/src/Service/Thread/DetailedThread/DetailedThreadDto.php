<?php

namespace App\Service\Thread\DetailedThread;

class DetailedThreadDto
{
    /**
     * @param list<string> $tags
     * @param list<DetailedThreadPostDto> $posts
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $content,
        public readonly array $tags,
        public readonly array $posts,
        public readonly DetailedThreadUserDto $user,
        public readonly string $createdAt,
    ) {
    }
}