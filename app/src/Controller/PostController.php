<?php

namespace App\Controller;

use App\Service\Post\PostService;
use App\Service\Post\WritePostDto;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PostController extends AbstractController
{
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    #[Route("/threads/{threadId}/posts", methods: ["POST"], name: "post_create")]
    public function create(
        int $threadId,
        #[CurrentUser] $userEntity,
        #[MapRequestPayload] WritePostDto $writePost
    ): JsonResponse {
        return $this->json($this->postService->create($threadId, $userEntity, $writePost), 201);
    }

    #[Route("/threads/{threadId}/posts/{postId}", methods: ["PUT"], name: "post_update")]
    public function update(
        int $threadId,
        int $postId,
        #[MapRequestPayload] WritePostDto $writePost
    ): JsonResponse {
        return $this->json($this->postService->update($threadId, $postId, $writePost), 201);
    }

    #[Route("/threads/{threadId}/posts/{postId}", methods: ["DELETE"], name: "post_remove")]
    public function remove(int $threadId, int $postId): JsonResponse
    {
        $this->postService->delete($threadId, $postId);

        return $this->json([], 204);

    }
}
