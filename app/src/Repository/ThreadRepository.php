<?php

namespace App\Repository;

use App\Entity\Thread;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Thread\ThreadRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Thread>
 */
class ThreadRepository extends ServiceEntityRepository implements ThreadRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thread::class);
    }

    /**
     * @return list<Thread>
     */
    public function findAllListed(): array
    {
        return $this->createQueryBuilder("thread")
            ->addSelect("threadTag, tag, post, user")
            ->leftJoin("thread.threadTags", "threadTag")
            ->leftJoin("threadTag.tag", "tag")
            ->leftJoin("thread.posts", "post")
            ->leftJoin("thread.user", "user")
            ->orderBy("post.createdAt", "DESC")
            ->getQuery()
            ->getResult();
    }

    public function findDetailedById(int $id): ?Thread
    {
        return $this->createQueryBuilder("thread")
            ->addSelect("threadTags, tag, posts")
            ->leftJoin("thread.threadTags", "threadTags")
            ->leftJoin("threadTags.tag", "tag")
            ->leftJoin("thread.posts", "posts")
            ->where("thread.id = :id")
            ->setParameter("id", $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function persist(Thread $thread): Thread
    {
        $em = $this->getEntityManager();
        $em->persist($thread);

        $em->flush();

        return $thread;
    }

    public function remove(Thread $thread): void
    {
        $em = $this->getEntityManager();
        $em->remove($thread);

        $em->flush();
    }

    //    /**
    //     * @return Thread[] Returns an array of Thread objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Thread
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
