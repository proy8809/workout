<?php

namespace App\Controller;

use App\Entity\Thread;
use App\Service\Thread\WritePostDto;
use App\Service\Thread\ThreadService;
use App\Service\Thread\WriteThreadDto;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ThreadController extends AbstractController
{
    public function __construct(
        private readonly ThreadService $threadService,
    ) {
    }

    #[Route('/threads/{threadId}', methods: ["GET"], name: 'thread_get')]
    public function get(int $threadId): JsonResponse
    {
        return $this->json($this->threadService->get($threadId));
    }

    #[Route('/threads', methods: ["GET"], name: 'thread_list')]
    public function list(): JsonResponse
    {
        return $this->json($this->threadService->list());
    }

    #[Route('/threads', methods: ["POST"], name: 'thread_create')]
    public function create(
        #[CurrentUser] $userEntity,
        #[MapRequestPayload] WriteThreadDto $writeThread
    ): JsonResponse {
        return $this->json($this->threadService->create($userEntity, $writeThread), 201);
    }

    #[Route('/threads/{id}', methods: ["PUT"], name: 'thread_update')]
    public function update(int $threadId, #[MapRequestPayload] WriteThreadDto $writeThread): JsonResponse
    {
        return $this->json($this->threadService->update($threadId, $writeThread));
    }

    #[Route('/threads/{threadId}', methods: ["DELETE"], name: 'thread_delete')]
    public function remove(int $threadId): JsonResponse
    {
        $this->threadService->delete($threadId);

        return $this->json([], 204);
    }
}
