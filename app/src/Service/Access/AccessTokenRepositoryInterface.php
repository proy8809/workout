<?php

namespace App\Service\Access;

use App\Entity\AccessToken;

interface AccessTokenRepositoryInterface
{
    public function findByToken(string $token): ?AccessToken;

    public function persist(AccessToken $accessToken): AccessToken;

    public function remove(AccessToken $accessToken): void;
}