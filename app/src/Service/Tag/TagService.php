<?php

namespace App\Service\Tag;

use App\Entity\Tag;

class TagService
{
    public function __construct(
        private readonly TagRepositoryInterface $tagRepository,
        private readonly TagMapper $tagMapper
    ) {
    }

    /**
     * @return TagDto[]
     */
    public function list(): array
    {
        $tagEntities = $this->tagRepository->findAll();

        return array_map(fn(Tag $tagEntity) => $this->tagMapper->entityToDto($tagEntity), $tagEntities);
    }

    public function create(CreateTagDto $createTag): TagDto
    {
        $tagEntity = new Tag(
            title: $createTag->title,
            canonical: $createTag->canonical
        );

        $tagEntity = $this->tagRepository->persist($tagEntity);

        return $this->tagMapper->entityToDto($tagEntity);
    }

    public function remove(int $id): void
    {
        $tagEntity = $this->tagRepository->findById($id);
        $this->tagRepository->remove($tagEntity);
    }
}