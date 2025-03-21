<?php

namespace App\Service\Post;

use Closure;
use App\Entity\Post;
use App\Entity\User;
use App\Service\Thread\ThreadRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService
{
    /**
     * @param \Closure(Post): PostDto $mapPost
     */
    public function __construct(
        private readonly ThreadRepositoryInterface $threadRepository,
        private readonly PostRepositoryInterface $postRepository,
        private readonly Closure $mapPost
    ) {
    }

    public function create(int $threadId, User $userEntity, WritePostDto $writePost): PostDto
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        if (!isset($threadEntity)) {
            throw new NotFoundHttpException("Thread does not exist");
        }

        $postEntity = new Post(
            user: $userEntity,
            thread: $threadEntity,
            content: $writePost->content
        );

        $postEntity = $this->postRepository->persist($postEntity);

        return ($this->mapPost)($postEntity);
    }

    public function update(int $threadId, int $postId, WritePostDto $writePost): PostDto
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        if (!isset($threadEntity)) {
            throw new NotFoundHttpException("Thread does not exist");
        }

        $postEntity = $this->postRepository->findById($postId);

        if (!isset($postEntity)) {
            throw new NotFoundHttpException("Post does not exist");
        }

        $postEntity->setContent($writePost->content);

        $postEntity = $this->postRepository->persist($postEntity);

        return ($this->mapPost)($postEntity);
    }

    public function delete(int $threadId, int $postId): void
    {
        $threadEntity = $this->threadRepository->findDetailedById($threadId);

        if (!isset($threadEntity)) {
            throw new NotFoundHttpException("Thread does not exist");
        }

        $postEntity = $this->postRepository->findById($postId);

        if (!isset($postEntity)) {
            throw new NotFoundHttpException("Post does not exist");
        }

        $this->postRepository->remove($postEntity);
    }
}