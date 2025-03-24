<?php

namespace App\Service\Thread\ListedThread;

use App\Entity\Thread;
use App\Enum\SortDirection;

class ListedThreadSorter
{
    /**
     * @param list<Thread> $threads
     *
     * @return list<Thread>
     */
    public function __invoke(array $threads, SortDirection $sortDirection = SortDirection::Ascending): array
    {
        uasort($threads, fn(Thread $compared, Thread $reference) =>
            $sortDirection === SortDirection::Ascending ?
                $compared->getCreatedAt()->getTimestamp() <=> $reference->getCreatedAt()->getTimestamp() :
                $reference->getCreatedAt()->getTimestamp() <=> $compared->getCreatedAt()->getTimestamp()
        );

        return $threads;
    }
}