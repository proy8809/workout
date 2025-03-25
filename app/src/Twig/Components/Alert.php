<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class Alert
{
    private const string VARIANT_PRIMARY = "primary";
    private const string VARIANT_SECONDARY = "secondary";
    private const string VARIANT_DANGER = "danger";

    public string $content;
    public string $alertClass;

    #[PreMount]
    public function preMount(array $data): array {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->setDefaults([
            "content" => "",
            "variant" => "primary",
        ]);

        $resolver->setAllowedValues("variant", [
            self::VARIANT_PRIMARY,
            self::VARIANT_SECONDARY,
            self::VARIANT_DANGER,
        ]);

        return $resolver->resolve($data) + $data;
    }

    #[PostMount]
    public function postMount(array $data): void {
        $this->alertClass = sprintf("alert %s", $data["variant"]);
    }
}
