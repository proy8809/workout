<?php

namespace App\Service\Access;

use App\Entity\User;
use App\Service\User\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccessService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function login(LoginDto $loginDto): AccessTokenDto
    {
        $user = $this->userRepository->findByEmail($loginDto->email);

        if (!isset($user)) {
            throw new UnauthorizedHttpException("Invalid credentials");
        }

        if (!$this->passwordHasher->isPasswordValid($user, $loginDto->password)) {
            throw new UnauthorizedHttpException("Invalid credentials");
        }

        if ($user->hasActiveAccessToken()) {
            throw new BadRequestHttpException("Already logged in");
        }

        $accessToken = bin2hex(random_bytes(32));
        $user->addAccessToken($accessToken);

        $this->userRepository->persist($user);

        return new AccessTokenDto(token: $accessToken);
    }

    public function logout(User $user): void
    {
        $user->clearAccessTokens();
        $this->userRepository->persist($user);
    }
}