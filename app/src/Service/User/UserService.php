<?php

namespace App\Service\User;

use App\Enum\Role;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserMapper $userMapper,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * @return UserDto[]
     */
    public function list(): array
    {
        $userEntities = $this->userRepository->findAll();

        return array_map(fn(User $userEntity) => $this->userMapper->entityToDto($userEntity), $userEntities);
    }

    public function create(CreateUserDto $createUserDto): UserDto
    {
        if ($this->userRepository->exists($createUserDto->email)) {
            throw new ConflictHttpException("A user with the email {$createUserDto->email} already exists.");
        }

        $userEntity = new User();

        $userEntity->setEmail($createUserDto->email);
        $userEntity->setFirstName($createUserDto->email);
        $userEntity->setLastName($createUserDto->email);
        $userEntity->setPassword(
            $this->passwordHasher->hashPassword($userEntity, $createUserDto->password)
        );
        $userEntity->setRoles($createUserDto->roles);

        $userEntity = $this->userRepository->persist($userEntity);

        return $this->userMapper->entityToDto($userEntity);
    }

    public function delete(int $id): void
    {
        $userEntity = $this->userRepository->findById($id);

        if (!isset($userEntity)) {
            return;
        }

        $this->userRepository->remove($userEntity);
    }
}