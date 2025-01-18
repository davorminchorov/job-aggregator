<?php

namespace App\Enums;

enum CompanySize: string
{
    case MICRO = '1-10';
    case SMALL = '11-50';
    case MEDIUM = '51-200';
    case LARGE = '201-500';
    case XLARGE = '501-1000';
    case XXLARGE = '1001-5000';
    case XXXLARGE = '5001-10000';
    case MASSIVE = '10000+';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function startupSizes(): array
    {
        return [
            self::MICRO->value,
            self::SMALL->value,
        ];
    }

    public static function enterpriseSizes(): array
    {
        return [
            self::XXLARGE->value,
            self::XXXLARGE->value,
            self::MASSIVE->value,
        ];
    }
}
