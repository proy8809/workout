<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThreadTagRepository;

#[ORM\Entity(repositoryClass: ThreadTagRepository::class)]
#[ORM\Table(name: "thread_tags")]

class ThreadTag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private DateTimeImmutable $addedAt;

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'threadTags')]
        #[ORM\JoinColumn(nullable: false)]
        private Thread $thread,

        #[ORM\ManyToOne]
        #[ORM\JoinColumn(nullable: false)]
        private Tag $tag
    ) {
        $this->addedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThread(): Thread
    {
        return $this->thread;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function getAddedAt(): DateTimeImmutable
    {
        return $this->addedAt;
    }
}
