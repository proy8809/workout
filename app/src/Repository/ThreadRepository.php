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

    public function persist(Thread $thread): Thread
    {
        $em = $this->getEntityManager();
        $em->persist($thread);

        $em->flush();

        return $thread;
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
