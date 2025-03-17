<?php

namespace App\Service\Tag;

class CreateTagDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $canonical,
    ) {
    }
}