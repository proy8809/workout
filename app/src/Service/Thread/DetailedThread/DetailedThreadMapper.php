<?php

namespace App\Service\Thread\DetailedThread;

use Closure;
use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Thread;
use App\Service\Post\PostDto;
use App\Service\Shared\ResourceUserDto;

class DetailedThreadMapper
{
    /**
     * @param \Closure(Post): PostDto $mapPost
     * @param \Closure(User): ResourceUserDto $mapResourceUser
     */
    public function __construct(
        private Closure $mapPost,
        private Closure $mapResourceUser
    ) {
    }

    public function __invoke(Thread $thread): DetailedThreadDto
    {
        return new DetailedThreadDto(
            id: $thread->getId(),
            title: $thread->getTitle(),
            content: $thread->getContent(),
            tags: $thread->getTags()->map(
                fn(Tag $tag) => $tag->getCanonical()
            )->toArray(),
            posts: $thread->getPosts()->map(
                fn(Post $post) => ($this->mapPost)($post)
            )->toArray(),
            user: ($this->mapResourceUser)($thread->getUser()),
            createdAt: $thread->getCreatedAt()->format("Y-m-d H:i:s")
        );
    }
}