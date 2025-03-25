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

    #[Route(path: '/threads', name: 'thread_list', methods: ["GET"])]
    public function list(): Response
    {
        return $this->render("thread/list.html.twig", [
            "threads" => $this->threadService->list(SortDirection::Descending)
        ]);
    }

    #[Route('/threads/{threadId}', name: 'thread_show', methods: ["GET"])]
    public function show(int $threadId): Response
    {
        return $this->render("thread/show.html.twig", [
            "thread" => $this->threadService->get($threadId)
        ]);
    }

    #[Route('/threads', name: 'thread_create', methods: ["POST"])]
    public function create(
        #[CurrentUser] $userEntity,
        #[MapRequestPayload] WriteThreadDto $writeThread
    ): JsonResponse {
        return $this->json($this->threadService->create($userEntity, $writeThread), 201);
    }

    #[Route('/threads/{id}', name: 'thread_update', methods: ["PUT"])]
    public function update(int $threadId, #[MapRequestPayload] WriteThreadDto $writeThread): JsonResponse
    {
        return $this->json($this->threadService->update($threadId, $writeThread));
    }

    #[Route('/threads/{threadId}', name: 'thread_delete', methods: ["DELETE"])]
    public function remove(int $threadId): JsonResponse
    {
        $this->threadService->delete($threadId);

        return $this->json([], 204);
    }
}
