<?php

namespace App\Service\Thread;

use App\Entity\Thread;

interface ThreadRepositoryInterface
{
    public function persist(Thread $thread, bool $flush = false);

    public function flush(): void;
}