<?php

namespace App\Service\Tag;

use App\Entity\Tag;

interface TagRepositoryInterface
{
    public function findById(int $id): Tag;

    /**
     * @param list<string> $canonicals
     * @return Tag[]
     */
    public function findByCanonicals(array $canonicals): array;

    /**
     * @return Tag[]
     */
    public function findAll(): array;

    public function persist(Tag $tag): Tag;

    public function remove(Tag $tag): void;
}