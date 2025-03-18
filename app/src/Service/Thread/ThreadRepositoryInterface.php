<?php

namespace App\Service\Thread;

use App\Entity\Thread;

interface ThreadRepositoryInterface
{
    public function persist(Thread $thread);
}