<?php

namespace App\Service\Tag;

use App\Entity\Tag;

class TagMapper
{
    public function entityToDto(Tag $tag): TagDto
    {
        return new TagDto(
            id: $tag->getId(),
            title: $tag->getTitle()
        );
    }
}