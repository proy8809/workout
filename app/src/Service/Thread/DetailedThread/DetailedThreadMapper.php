<?php

namespace App\Service\Thread\DetailedThread;

use Closure;
use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Thread;

class DetailedThreadMapper
{
    /**
     * @param \Closure(Post): DetailedThreadPostDto $mapDetailedThreadPost
     * @param \Closure(User): DetailedThreadUserDto $mapDetailedThreadUser
     */
    public function __construct(
        private Closure $mapDetailedThreadPost,
        private Closure $mapDetailedThreadUser
    ) {
    }

    public function __invoke(Thread $thread): DetailedThreadDto
    {
        $tags = $thread->getTags()->map(
            fn(Tag $tag) => $tag->getCanonical()
        )->toArray();

        $posts = $thread->getPosts()->map(
            fn(Post $post) => ($this->mapDetailedThreadPost)($post)
        )->toArray();

        $user = ($this->mapDetailedThreadUser)($thread->getUser());

        return new DetailedThreadDto(
            id: $thread->getId(),
            title: $thread->getTitle(),
            content: $thread->getContent(),
            tags: $tags,
            posts: $posts,
            user: $user,
            createdAt: $thread->getCreatedAt()->format("Y-m-d H:i:s")
        );
    }
}