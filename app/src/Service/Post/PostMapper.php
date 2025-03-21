<?php

namespace App\Service\Post;

use Closure;
use App\Entity\Post;
use App\Entity\User;
use App\Service\Shared\ResourceUserDto;

class PostMapper
{
    /**
     * @param \Closure(User): ResourceUserDto $mapResourceUser
     */
    public function __construct(
        private readonly Closure $mapResourceUser
    ) {
    }

    public function __invoke(Post $postEntity): PostDto
    {
        return new PostDto(
            id: $postEntity->getId(),
            content: $postEntity->getContent(),
            user: ($this->mapResourceUser)($postEntity->getUser()),
            createdAt: $postEntity->getCreatedAt()->format("Y-m-d H:i:s")
        );
    }
}