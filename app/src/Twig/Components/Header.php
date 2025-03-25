<?php

namespace App\Twig\Components;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Header
{
    public bool $isLoggedIn = false;

    public function __construct(Security $security) {
        $this->isLoggedIn = !is_null($security->getUser());
    }
}
