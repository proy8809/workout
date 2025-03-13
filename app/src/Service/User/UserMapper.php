<?php

namespace App\Service\User;

use App\Entity\User;

class UserMapper
{
    public function entityToDto(User $user): UserDto
    {
        return new UserDto(
            id: $user->getId(),
            email: $user->getEmail(),
            firstName: $user->getFirstName(),
            lastName: $user->getLastName(),
            roles: $user->getRoles()
        );
    }
}