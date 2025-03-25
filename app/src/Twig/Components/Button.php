<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class Button
{
    private const string VARIANT_PRIMARY = "primary";
    private const string VARIANT_SECONDARY = "secondary";
    private const string VARIANT_DANGER = "danger";
    private const string TYPE_SUBMIT = "submit";
    private const string TYPE_BUTTON = "button";
    private const string TYPE_RESET = "reset";

    public string $text;

    public string $type;
    public string $buttonClass;

    #[PreMount]
    public function preMount(array $data): array {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->setRequired([
            "text"
        ]);

        $resolver->setDefaults([
            "variant" => self::VARIANT_PRIMARY,
            "type" => self::TYPE_BUTTON
        ]);

        $resolver->setAllowedValues("variant", [
            self::VARIANT_PRIMARY,
            self::VARIANT_SECONDARY,
            self::VARIANT_DANGER
        ]);

        $resolver->setAllowedValues("type", [
            self::TYPE_SUBMIT,
            self::TYPE_BUTTON,
            self::TYPE_RESET
        ]);

        return $resolver->resolve($data) + $data;
    }

    #[PostMount]
    public function postMount(array $data): void {
        $this->buttonClass = sprintf("btn-%s", $data["variant"]);
    }
}
