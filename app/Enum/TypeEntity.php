<?php

namespace App\Enums;

enum TypeEntity: int
{
    case COLECTIVA = 1;
    case SINGULAR = 2;

    public function label(): string
    {
        return match ($this) {
            self::COLECTIVA => 'Colectiva',
            self::SINGULAR => 'Singular',
        };
    }
    public static function isValidValue(int $value): bool
    {
        return in_array($value, array_column(self::cases(), 'value'));
    }

    public static function values(): array
    {
        return array_column(array: self::cases(), column_key: 'value');
    }
}
