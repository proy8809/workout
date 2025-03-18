<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: "tags")]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 64)]
        private string $title,

        #[ORM\Column(length: 64)]
        private string $canonical
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCanonical(): string
    {
        return $this->canonical;
    }
}
