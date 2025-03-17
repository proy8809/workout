<?php

namespace App\Service\Thread;

use Symfony\Component\Validator\Constraints as Assert;

class WriteThreadDto
{
    /**
     * @param list<string> $tags
     */
    public function __construct(
        #[Assert\NotBlank(message: "Title can't be empty")]
        public readonly string $title,

        #[Assert\NotBlank(message: "Content can't be empty")]
        #[Assert\Length(min: 32, minMessage: "Content must be at least 32 characters long")]
        public readonly string $content,

        public readonly array $tags
    ) {
    }
}