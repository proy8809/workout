<?php

namespace App\Service\User;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function exists(string $email): bool;

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function persist(User $user): User;

    public function remove(User $user): void;
}