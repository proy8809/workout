<?php

namespace App\Service\Thread\DetailedThread;

use Closure;
use App\Entity\Post;
use App\Entity\User;

class DetailedThreadPostMapper
{
    /**
     * @param \Closure(User): DetailedThreadUserDto $mapDetailedThreadUser
     */
    public function __construct(
        private readonly Closure $mapDetailedThreadUser
    ) {
    }

    public function __invoke(Post $post): DetailedThreadPostDto
    {
        return new DetailedThreadPostDto(
            id: $post->getId(),
            content: $post->getContent(),
            user: ($this->mapDetailedThreadUser)($post->getUser()),
            createdAt: $post->getCreatedAt()->format("Y-m-d H:i:s")
        );
    }
}