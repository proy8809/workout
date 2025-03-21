<?php

namespace App\Service\Shared;

use App\Entity\User;

class ResourceUserMapper
{
    public function __invoke(User $user): ResourceUserDto
    {
        return new ResourceUserDto(
            id: $user->getId(),
            fullName: sprintf("%s %s", $user->getFirstName(), $user->getLastName())
        );
    }
}