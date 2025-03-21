<?php

namespace App\Service\Thread\ListedThread;

class ListedThreadDto
{
    /**
     * @param list<string> $tags
     */
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly array $tags,
        public readonly string $userFullName,
        public readonly int $nbPosts,
        public readonly string $createdAt,
        public readonly string $latestPostAt
    ) {
    }
}