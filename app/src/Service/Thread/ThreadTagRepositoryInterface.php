<?php

namespace App\Service\Thread;

use App\Entity\ThreadTag;

interface ThreadTagRepositoryInterface
{
    public function persist(ThreadTag $threadTag, bool $flush = false): ThreadTag;
    public function flush(): void;
}