<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class TextInput
{
    private const string TYPE_TEXT = "text";
    private const string TYPE_PASSWORD = "password";

    public string $id;
    public string $type;
    public string $name;
    public string $label;
    public string $value;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->setRequired([
            "id",
            "name",
            "label"
        ]);

        $resolver->setDefaults([
            "type" => self::TYPE_TEXT,
            "value" => ""
        ]);

        $resolver->setAllowedValues("type", [
            self::TYPE_TEXT,
            self::TYPE_PASSWORD
        ]);

        return $resolver->resolve($data) + $data;
    }
}
