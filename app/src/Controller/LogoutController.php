<?php

namespace App\Controller;

use App\Service\Access\AccessService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LogoutController extends AbstractController
{
    public function __construct(
        private readonly AccessService $accessService
    ) {
    }

    #[IsGranted("IS_AUTHENTICATED")]
    #[Route('/logout', name: 'logout_action', methods: ["POST"])]
    public function __invoke(#[CurrentUser] $user): JsonResponse
    {
        $this->accessService->logout($user);

        return $this->json([], 204);
    }
}
