<?php

namespace App\Service\Thread;

use App\Entity\Thread;
use App\Entity\User;
use App\Enum\SortDirection;
use App\Service\Tag\TagRepositoryInterface;
use App\Service\Thread\DetailedThread\DetailedThreadDto;
use App\Service\Thread\ListedThread\ListedThreadDto;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThreadService
{
    /**
     * @param \Closure(list<Thread>,SortDirection): list<Thread> $sortListedThreads
     * @param \Closure(Thread): DetailedThreadDto $mapDetailedThread
     * @param \Closure(Thread): ListedThreadDto $mapListedThread
     */
    public function __construct(
        private readonly ThreadRepositoryInterface $threadRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly Closure $sortListedThreads,
        private readonly Closure $mapDetailedThread,
        private readonly Closure $mapListedThread,
    ) {
    }

    public function get(int $threadId): DetailedThreadDto
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        if (!isset($threadEntity)) {
            throw new NotFoundHttpException("Thread does not exist");
        }

        return ($this->mapDetailedThread)($threadEntity);
    }

    /**
     * @return list<ListedThreadDto>
     */
    public function list(SortDirection $sortDirection = SortDirection::Ascending): array
    {
        $threadEntities = ($this->sortListedThreads)($this->threadRepository->findAllListed(), $sortDirection);

        return array_map(
            fn(Thread $thread) => ($this->mapListedThread)($thread),
            $threadEntities
        );
    }

    public function create(User $userEntity, WriteThreadDto $writeThread): DetailedThreadDto
    {
        $threadEntity = new Thread();

        $threadEntity->setUser($userEntity)
            ->setTitle($writeThread->title)
            ->setContent($writeThread->content)
            ->setCreatedAt(new \DateTimeImmutable());

        $tagEntities = $this->tagRepository->findByCanonicals($writeThread->tags);
        $threadEntity->setTags($tagEntities);

        $threadEntity = $this->threadRepository->persist($threadEntity);

        return ($this->mapDetailedThread)($threadEntity);
    }

    public function update(int $threadId, WriteThreadDto $writeThread): DetailedThreadDto
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        if (!isset($threadEntity)) {
            throw new NotFoundHttpException("Thread does not exist");
        }

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

        if (!isset($threadEntity)) {
            throw new NotFoundHttpException("Thread does not exist");
        }

        $this->threadRepository->remove($threadEntity);
    }
}