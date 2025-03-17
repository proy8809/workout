<?php

namespace App\Controller;

use App\Service\Access\LoginDto;
use App\Service\Access\AccessService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\RateLimiter\LimiterInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

final class LoginController extends AbstractController
{
    private readonly LimiterInterface $limiter;

    public function __construct(
        private readonly AccessService $accessService,
        RateLimiterFactory $apiLimiter
    ) {
        $this->limiter = $apiLimiter->create();
    }

    #[Route('/login', name: 'login_action', methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] LoginDto $loginDto): JsonResponse
    {
        if (!$this->limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }

        return $this->json(
            $this->accessService->login($loginDto),
            201
        );
    }
}
