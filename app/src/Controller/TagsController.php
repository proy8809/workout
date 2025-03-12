<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Request\CreateTagDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TagsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/tags', name: 'tags_all', methods: ["GET"])]
    public function all(): JsonResponse
    {
        $tagRepository = $this->entityManager->getRepository(Tag::class);
        $tags = $tagRepository->findAllForList();

        return $this->json($tags, 200);
    }

    #[Route('/tags', name: 'tags_create', methods: ["POST"])]
    public function create(#[MapRequestPayload] CreateTagDto $createTag): JsonResponse
    {
        $tag = new Tag();
        $tag->setTitle($createTag->title);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $this->json([
            "id" => $tag->getId(),
            "title" => $tag->getTitle()
        ], 201);
    }

    #[Route('/tags/{id}', name: 'tags_delete', methods: ["DELETE"])]
    public function delete(Tag $tag): JsonResponse
    {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();

        return $this->json([], 204);
    }
}
