<?php

namespace App\Service\Post;

use App\Entity\Post;
use App\Enum\SortDirection;

readonly class PostSorter
{
    public function __construct(
        private SortDirection $sortDirection = SortDirection::Ascending
    ) {
    }

    /**
     * @param list<Post> $posts
     * @return list<Post>
     */
    public function __invoke(array $posts): array
    {
        uasort($posts, fn(Post $compared, Post $reference) =>
            $this->sortDirection === SortDirection::Ascending ?
                $compared->getCreatedAt()->getTimestamp() <=> $reference->getCreatedAt()->getTimestamp() :
                $reference->getCreatedAt()->getTimestamp() <=> $compared->getCreatedAt()->getTimestamp()
        );

        return $posts;
    }
}