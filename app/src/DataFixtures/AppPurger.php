<?php

namespace App\DataFixtures;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurgerInterface;

class AppPurger implements PurgerInterface, ORMPurgerInterface
{
    private EntityManagerInterface $em;

    /**
     * @var list<'tags'|'users'>
     */
    private array $exclusions = [];

    private function purgeTags(): void
    {
        $connection = $this->em->getConnection();
        $connection->executeStatement("DELETE FROM tags");
    }

    private function purgeUsers(): void
    {
        $connection = $this->em->getConnection();
        $connection->executeStatement("DELETE FROM users WHERE JSON_CONTAINS(roles, '\"ROLE_ADMIN\"') = 1");
    }

    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param list<'tags'|'users'> $exclusions
     */
    public function setExclusions(array $exclusions): void
    {
        $this->exclusions = $exclusions;
    }

    public function purge(): void
    {
        if (!in_array("tags", $this->exclusions)) {
            $this->purgeTags();
        }

        if (!in_array("users", $this->exclusions)) {
            $this->purgeUsers();
        }
    }
}