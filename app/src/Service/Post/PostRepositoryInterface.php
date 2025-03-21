<?php

namespace App\Service\Post;

use App\Entity\Post;

interface PostRepositoryInterface
{
    public function findById(int $id): ?Post;

    public function persist(Post $post): Post;

    public function remove(Post $post): void;
}