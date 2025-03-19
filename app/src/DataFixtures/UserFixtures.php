<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Service\User\UserRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User(
            email: "patrice.roy@doyondespres.com",
            firstName: "Patrice",
            lastName: "Roy",
        );

        $user->setRoles(["ROLE_ADMIN"]);

        $password = $this->userPasswordHasher->hashPassword($user, "foobar123");
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * @return list<string>
     */
    public static function getGroups(): array
    {
        return ["bootstrap"];
    }
}