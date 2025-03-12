<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTagDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 64)]
        public readonly string $title
    ) {
    }
}