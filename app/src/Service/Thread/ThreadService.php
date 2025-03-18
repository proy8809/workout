<?php

namespace App\Service\Thread;

use Closure;
use App\Entity\User;
use App\Entity\Thread;
use App\Service\Tag\TagRepositoryInterface;
use App\Service\Thread\DetailedThread\DetailedThreadDto;

class ThreadService
{
    /**
     * @param \Closure(Thread): DetailedThreadDto $mapDetailedThread
     */
    public function __construct(
        private readonly ThreadRepositoryInterface $threadRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly Closure $mapDetailedThread
    ) {
    }

    public function create(User $userEntity, WriteThreadDto $writeThread): DetailedThreadDto
    {
        $threadEntity = new Thread(
            user: $userEntity,
            title: $writeThread->title,
            content: $writeThread->content
        );

        $tagEntities = $this->tagRepository->findByCanonicals($writeThread->tags);

        foreach ($tagEntities as $tagEntity) {
            $threadEntity->addTag($tagEntity);
        }

        $threadEntity = $this->threadRepository->persist($threadEntity);

        return ($this->mapDetailedThread)($threadEntity);
    }
}