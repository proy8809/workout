<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Tag\TagRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class TagRepository extends ServiceEntityRepository implements TagRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Tag::class);
    }

    public function findById(int $id): Tag
    {
        return $this->find($id);
    }

    public function persist(Tag $tag): Tag
    {
        $em = $this->getEntityManager();
        $em->persist($tag);
        $em->flush();

        return $tag;
    }

    public function remove(Tag $tag): void
    {
        $em = $this->getEntityManager();
        $em->remove($tag);
        $em->flush();
    }
}
