<?php

namespace App\Service\Thread;

use App\Entity\Thread;

interface ThreadRepositoryInterface
{
    public function findDetailedById(int $id): ?Thread;

    /**
     * @return list<Thread>
     */
    public function findAllListed(): array;

    public function persist(Thread $thread): Thread;

    public function remove(Thread $thread): void;
}