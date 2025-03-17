<?php

namespace App\Service\Thread;

use App\Entity\User;
use App\Entity\Thread;
use DateTimeImmutable;
use App\Entity\ThreadTag;
use App\Service\Tag\TagRepositoryInterface;

class ThreadService
{
    public function __construct(
        private readonly ThreadRepositoryInterface $threadRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly ThreadTagRepositoryInterface $threadTagRepository
    ) {
    }

    public function create(User $userEntity, WriteThreadDto $writeThread): void
    {
        $processedAt = new DateTimeImmutable();

        $threadEntity = new Thread();

        $threadEntity->setTitle($writeThread->title);
        $threadEntity->setContent($writeThread->content);
        $threadEntity->setUser($userEntity);
        $threadEntity->setCreatedAt($processedAt);

        $tagEntities = $this->tagRepository->findByCanonical($writeThread->tags);

        foreach ($tagEntities as $tagEntity) {
            $threadTagEntity = new ThreadTag();
            $threadTagEntity->setThread($threadEntity);
            $threadTagEntity->setTag($tagEntity);
            $threadTagEntity->setAddedAt($processedAt);

            $threadEntity->addThreadTag($threadTagEntity);

            $this->threadTagRepository->persist($threadTagEntity, false);
        }

        $this->threadRepository->persist($threadEntity, false);

        $this->threadRepository->flush();
    }
}