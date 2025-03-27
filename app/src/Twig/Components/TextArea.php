<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class TextArea
{
    public string $id;
    public string $name;
    public string $label;
    public int $rows;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->setRequired(["id", "name", "label"]);

        $resolver->setDefault("rows", 4);
        $resolver->setAllowedTypes("rows", "int");

        return $resolver->resolve($data) + $data;
    }
}
