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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, ThreadTag>
     */
    #[ORM\OneToMany(targetEntity: ThreadTag::class, mappedBy: 'thread', cascade: ["persist"], orphanRemoval: true)]
    private Collection $threadTags;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'thread', cascade: ["persist"], orphanRemoval: true)]
    private Collection $posts;

    public function __construct() {
        $this->threadTags = new ArrayCollection();
        $this->posts = new ArrayCollection();

        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->threadTags->map(fn(ThreadTag $threadTag) => $threadTag->getTag());
    }

    public function getNbPosts(): int
    {
        return $this->posts->count();
    }

    public function getLatestPostAt(): DateTimeImmutable
    {
        $iterator = $this->posts->getIterator();
        $iterator->uasort(
            fn(Post $compared, Post $reference) =>
            $compared->getCreatedAt()->getTimestamp() > $reference->getCreatedAt()->getTimestamp() ? -1 : 1
        );

        /**
         * @var Collection<int,Post>
         */
        $collection = new ArrayCollection(iterator_to_array($iterator));

        if ($collection->isEmpty()) {
            return $this->createdAt;
        }

        return $collection->first()->getCreatedAt();
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function setUser(User $user): static {
        $this->user = $user;

        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param list<Tag> $tags
     */
    public function setTags(array $tags): static
    {
        $this->threadTags = new ArrayCollection();

        foreach ($tags as $tag) {
            $threadTag = new ThreadTag($this, $tag);
            $this->threadTags->add($threadTag);
        }

        return $this;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setThread($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }

        return $this;
    }
}
