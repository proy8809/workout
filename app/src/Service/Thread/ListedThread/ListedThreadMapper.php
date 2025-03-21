<?php

namespace App\Service\Thread\ListedThread;

use App\Entity\Tag;
use App\Entity\Thread;

class ListedThreadMapper
{
    public function __invoke(Thread $threadEntity): ListedThreadDto
    {
        return new ListedThreadDto(
            id: $threadEntity->getId(),
            title: $threadEntity->getTitle(),
            tags: $threadEntity->getTags()->map(fn(Tag $tag) => $tag->getTitle())->toArray(),
            userFullName: sprintf(
                "%s %s",
                $threadEntity->getUser()->getFirstName(),
                $threadEntity->getUser()->getLastName()
            ),
            nbPosts: $threadEntity->getNbPosts(),
            createdAt: $threadEntity->getCreatedAt()->format("Y-m-d H:i:s"),
            latestPostAt: $threadEntity->getLatestPostAt()->format("Y-m-d H:i:s"),
        );
    }
}