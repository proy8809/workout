<?php

namespace App\Controller;

use App\Request\CreateTagDto;
use App\Service\Tag\TagService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TagsController extends AbstractController
{
    public function __construct(
        private readonly TagService $tagService
    ) {
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/tags', name: 'tags_list', methods: ["GET"])]
    public function list(): JsonResponse
    {
        return $this->json($this->tagService->list(), 200);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/tags', name: 'tags_create', methods: ["POST"])]
    public function create(#[MapRequestPayload] CreateTagDto $createTag): JsonResponse
    {
        return $this->json($this->tagService->create($createTag->title), 201);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/tags/{id}', name: 'tags_remove', methods: ["DELETE"])]
    public function remove(int $id): JsonResponse
    {
        return $this->json($this->tagService->remove($id), 204);
    }
}
