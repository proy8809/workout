<?php

namespace App\Service\Thread\DetailedThread;

use App\Entity\User;

class DetailedThreadUserMapper
{
    public function __invoke(User $user): DetailedThreadUserDto
    {
        return new DetailedThreadUserDto(
            id: $user->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName()
        );
    }
}