<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class Link
{
    public string $to;
    public string $text;

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->setRequired(["to", "text"]);
        $resolver->setAllowedTypes("to", ["string"]);
        $resolver->setAllowedTypes("text", ["string"]);

        return $resolver->resolve($data) + $data;
    }
}
