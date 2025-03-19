<?php

namespace App\DataFixtures;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Tag\TagRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Purger\PurgerFactory;
use Doctrine\Common\DataFixtures\Purger\ORMPurgerInterface;

class AppPurgerFactory implements PurgerFactory
{
    public function __construct(
        private readonly TagRepositoryInterface $tagRepository
    ) {
    }

    public function createForEntityManager(string|null $emName, EntityManagerInterface $em, array $excluded = [], bool $purgeWithTruncate = false): ORMPurgerInterface
    {
        if ($purgeWithTruncate) {
            throw new Exception("--purge-with-truncate not supported");
        }

        $purger = new AppPurger();
        $purger->setEntityManager($em);
        $purger->setExclusions($excluded);

        return $purger;
    }
}