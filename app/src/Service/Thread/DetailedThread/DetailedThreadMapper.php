<?php

namespace App\Service\Thread\DetailedThread;

use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\Thread;
use App\Entity\User;
use App\Service\Post\PostDto;
use App\Service\Shared\ResourceUserDto;
use Closure;

readonly class DetailedThreadMapper
{
    /**
     * @param \Closure(Post): PostDto $mapPost
     * @param \Closure(list<Post>): list<Post> $sortPosts
     * @param \Closure(User): ResourceUserDto $mapResourceUser
     */
    public function __construct(
        private Closure $mapPost,
        private Closure $sortPosts,
        private Closure $mapResourceUser
    ) {
    }

    public function __invoke(Thread $thread): DetailedThreadDto
    {
        $threadPostEntities = $thread->getPosts()->toArray();
        $threadPostEntities = ($this->sortPosts)($threadPostEntities);

        return new DetailedThreadDto(
            id: $thread->getId(),
            title: $thread->getTitle(),
            content: $thread->getContent(),
            tags: $thread->getTags()->map(
                fn(Tag $tag) => $tag->getCanonical()
            )->toArray(),
            posts: array_map(fn(Post $postEntity) => ($this->mapPost)($postEntity), $threadPostEntities),
            user: ($this->mapResourceUser)($thread->getUser()),
            createdAt: $thread->getCreatedAt()->format("Y-m-d H:i:s")
        );
    }
}