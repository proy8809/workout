<?php

namespace App\Service\Access;

use DateTimeImmutable;
use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly AccessTokenRepositoryInterface $accessTokenRepository
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        $accessTokenEntity = $this->accessTokenRepository->findByToken($accessToken);

        if (!isset($accessTokenEntity) || $accessTokenEntity->getExpiresAt() < new DateTimeImmutable()) {
            throw new BadCredentialsException("Invalid credentials");
        }

        return new UserBadge($accessTokenEntity->getUser()->getUserIdentifier());
    }
}