<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Post\PostRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findById(int $id): ?Post
    {
        return $this->find($id);
    }

    public function persist(Post $post): Post
    {
        $em = $this->getEntityManager();
        $em->persist($post);
        $em->flush();

        return $post;
    }

    public function remove(Post $post): void
    {
        $em = $this->getEntityManager();
        $em->remove($post);
        $em->flush();
    }
}
