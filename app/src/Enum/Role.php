<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN = "ROLE_ADMIN";
    case USER = "ROLE_USER";

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), "value");
    }
}