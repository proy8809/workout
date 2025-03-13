<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN = "admin";
    case USER = "user";

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), "value");
    }
}