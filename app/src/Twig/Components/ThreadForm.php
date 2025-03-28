<?php

namespace App\Twig\Components;

use App\Entity\Thread;
use App\Entity\User;
use App\Service\Thread\ThreadRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ThreadForm
{
    use DefaultActionTrait;

    #[LiveProp(writable: ["title", "content"])]
    public Thread $thread;

    public function __construct(
        private readonly ThreadRepositoryInterface $threadRepository,
    ) {
    }

    public function mount(?Thread $thread = null): void {
        $this->thread = $thread ?? new Thread();
    }

    #[LiveAction]
    public function saveThread(#[CurrentUser] User $user): void {
        $this->thread->setUser($user);
        $this->thread->setCreatedAt(new \DateTimeImmutable());

        $this->threadRepository->persist($this->thread);
    }
}
