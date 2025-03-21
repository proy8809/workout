<?php

namespace App\Service\Post;

class WritePostDto
{
    public function __construct(
        public readonly string $content
    ) {
    }
}