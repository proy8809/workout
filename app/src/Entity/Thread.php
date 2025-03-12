<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
#[ORM\Table(name: "threads")]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'threads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, ThreadTag>
     */
    #[ORM\OneToMany(targetEntity: ThreadTag::class, mappedBy: 'thread', orphanRemoval: true)]
    private Collection $threadTags;

    public function __construct()
    {
        $this->threadTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->content;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * @return Collection<int, ThreadTag>
     */
    public function getThreadTags(): Collection
    {
        return $this->threadTags;
    }

    public function addThreadTag(ThreadTag $threadTag): static
    {
        if (!$this->threadTags->contains($threadTag)) {
            $this->threadTags->add($threadTag);
            $threadTag->setThread($this);
        }

        return $this;
    }

    public function removeThreadTag(ThreadTag $threadTag): static
    {
        if ($this->threadTags->removeElement($threadTag)) {
            // set the owning side to null (unless already changed)
            if ($threadTag->getThread() === $this) {
                $threadTag->setThread(null);
            }
        }

        return $this;
    }
}
