<?php

namespace App\Service\Thread;

use Closure;
use App\Entity\User;
use App\Entity\Thread;
use App\Service\Tag\TagRepositoryInterface;
use App\Service\Thread\ListedThread\ListedThreadDto;
use App\Service\Thread\DetailedThread\DetailedThreadDto;

class ThreadService
{
    /**
     * @param \Closure(Thread): DetailedThreadDto $mapDetailedThread
     * @param \Closure(Thread): ListedThreadDto $mapListedThread
     */
    public function __construct(
        private readonly ThreadRepositoryInterface $threadRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly Closure $mapDetailedThread,
        private readonly Closure $mapListedThread,
    ) {
    }

    public function get(int $threadId): DetailedThreadDto
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        return ($this->mapDetailedThread)($threadEntity);
    }

    /**
     * @return list<ListedThreadDto>
     */
    public function list(): array
    {
        $threadEntities = $this->threadRepository->findAllListed();

        return array_map(
            fn(Thread $thread) => ($this->mapListedThread)($thread),
            $threadEntities
        );
    }

    public function create(User $userEntity, WriteThreadDto $writeThread): DetailedThreadDto
    {
        $threadEntity = new Thread(
            user: $userEntity,
            title: $writeThread->title,
            content: $writeThread->content
        );

        $tagEntities = $this->tagRepository->findByCanonicals($writeThread->tags);
        $threadEntity->setTags($tagEntities);

        $threadEntity = $this->threadRepository->persist($threadEntity);

        return ($this->mapDetailedThread)($threadEntity);
    }

    public function update(int $threadId, WriteThreadDto $writeThread): DetailedThreadDto
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        $threadEntity->setTitle($writeThread->title);
        $threadEntity->setContent($writeThread->content);

        $tagEntities = $this->tagRepository->findByCanonicals($writeThread->tags);
        $threadEntity->setTags($tagEntities);

        $threadEntity = $this->threadRepository->persist($threadEntity);

        return ($this->mapDetailedThread)($threadEntity);
    }

    public function delete(int $threadId): void
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        $this->threadRepository->remove($threadEntity);
    }
}