<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: "tags")]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    /**
     * @var Collection<int, ThreadTag>
     */
    #[ORM\OneToMany(targetEntity: ThreadTag::class, mappedBy: 'tag', orphanRemoval: true)]
    private Collection $threadTags;

    public function __construct()
    {
        $this->threadTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $threadTag->setTag($this);
        }

        return $this;
    }

    public function removeThreadTag(ThreadTag $threadTag): static
    {
        if ($this->threadTags->removeElement($threadTag)) {
            // set the owning side to null (unless already changed)
            if ($threadTag->getTag() === $this) {
                $threadTag->setTag(null);
            }
        }

        return $this;
    }
}
