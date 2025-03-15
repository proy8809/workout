<?php

namespace App\Controller;

use App\Service\User\UserService;
use App\Service\User\CreateUserDto;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UsersController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route("/users", name: "users_list", methods: ["GET"])]
    public function list(): JsonResponse
    {
        return $this->json($this->userService->list(), 200);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route("/users", name: "users_create", methods: ["POST"])]
    public function create(#[MapRequestPayload()] CreateUserDto $createUser): JsonResponse
    {
        return $this->json($this->userService->create($createUser), 201);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route("/users/{id}", name: "users_remove", methods: ["DELETE"])]
    public function remove(int $id): JsonResponse
    {
        $this->userService->delete($id);

        return $this->json([], 204);
    }
}
