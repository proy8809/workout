<?php

namespace App\Controller;

use App\Service\Access\LoginDto;
use App\Service\Access\AccessService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LoginController extends AbstractController
{
    public function __construct(
        private readonly AccessService $accessService
    ) {
    }

    #[Route('/login', name: 'login_action', methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] LoginDto $loginDto): JsonResponse
    {
        return $this->json($this->accessService->login($loginDto), 201);
    }
}
