<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: "posts")]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'posts')]
        #[ORM\JoinColumn(nullable: false)]
        private User $user,

        #[ORM\ManyToOne(inversedBy: 'posts')]
        #[ORM\JoinColumn(nullable: false)]
        private Thread $thread,

        #[ORM\Column(type: Types::TEXT)]
        private string $content,
    ) {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThread(): Thread
    {
        return $this->thread;
    }


    public function getUser(): User
    {
        return $this->user;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setThread(Thread $thread): static
    {
        $this->thread = $thread;

        return $this;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
