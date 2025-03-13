<?php

namespace App\Service\Tag;

class TagDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
    ) {
    }
}