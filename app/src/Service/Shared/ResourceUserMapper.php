<?php

namespace App\Service\Shared;

use App\Entity\User;

class ResourceUserMapper
{
    public function __invoke(User $user): ResourceUserDto
    {
        return new ResourceUserDto(
            id: $user->getId(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName()
        );
    }
}