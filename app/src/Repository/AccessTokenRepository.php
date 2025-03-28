<?php

namespace App\Repository;

use App\Entity\AccessToken;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Access\AccessTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AccessToken>
 */
class AccessTokenRepository extends ServiceEntityRepository implements AccessTokenRepositoryInterface
{
    private readonly EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, AccessToken::class);

        $this->em = $em;
    }

    public function findByToken(string $token): ?AccessToken
    {
        return $this->createQueryBuilder("accessToken")
            ->addSelect("user")
            ->innerJoin("accessToken.user", "user")
            ->where("accessToken.token = :token")
            ->setParameter("token", $token)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function persist(AccessToken $accessToken): AccessToken
    {
        $this->em->persist($accessToken);
        $this->em->flush();

        return $accessToken;
    }

    public function remove(AccessToken $accessToken): void
    {
        $this->em->remove($accessToken);
        $this->em->flush();
    }

}
