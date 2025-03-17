<?php

namespace App\Listener;

use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

final class RequestListener
{
    public function __construct(
        private readonly RateLimiterFactory $apiLimiter
    ) {
    }

    #[AsEventListener(event: "kernel.request", priority: 4096)]
    public function handleRateLimiting(): void
    {
        $apiLimiting = $this->apiLimiter->create();

        if (!$apiLimiting->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }
    }
}