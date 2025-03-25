<?php

namespace App\Controller;

use App\Enum\SortDirection;
use App\Service\Thread\ThreadService;
use App\Service\Thread\WriteThreadDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class ThreadController extends AbstractController
{
    public function __construct(
        private readonly ThreadService $threadService,
    ) {
    }

    #[Route('/threads', methods: ["GET"], name: 'thread_list')]
    public function list(#[CurrentUser] $user): Response
    {
        return $this->render("thread/list.html.twig", [
            "threads" => $this->threadService->list(SortDirection::Descending)
        ]);
    }

    #[Route('/threads/{threadId}', methods: ["GET"], name: 'thread_show')]
    public function show(int $threadId): Response
    {
        return $this->render("thread/show.html.twig", [
            "thread" => $this->threadService->get($threadId)
        ]);
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
