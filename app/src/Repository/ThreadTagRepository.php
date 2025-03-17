<?php

namespace App\Repository;

use App\Entity\ThreadTag;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Thread\ThreadTagRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ThreadTag>
 */
class ThreadTagRepository extends ServiceEntityRepository implements ThreadTagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThreadTag::class);
    }


    public function persist(ThreadTag $threadTag, bool $flush = false): ThreadTag
    {
        $em = $this->getEntityManager();

        $em->persist($threadTag);

        if ($flush) {
            $this->flush();
        }

        return $threadTag;
    }

    public function flush(): void
    {
        $em = $this->getEntityManager();

        $em->flush();
    }

    //    /**
    //     * @return ThreadTag[] Returns an array of ThreadTag objects
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

    //    public function findOneBySomeField($value): ?ThreadTag
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
