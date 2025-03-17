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

    public function persist(Thread $thread, bool $flush = false): Thread
    {
        $em = $this->getEntityManager();

        $em->persist($thread);

        if ($flush) {
            $this->flush();
        }

        return $thread;
    }

    public function flush(): void
    {
        $em = $this->getEntityManager();

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
