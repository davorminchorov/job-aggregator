<?php

namespace App\Enums;

enum IndustryName: string
{
    case TECHNOLOGY = 'Technology';
    case HEALTHCARE = 'Healthcare';
    case FINANCE = 'Finance';
    case EDUCATION = 'Education';
    case ECOMMERCE = 'E-commerce';
    case MANUFACTURING = 'Manufacturing';
    case CONSULTING = 'Consulting';
    case MARKETING = 'Marketing';
    case REAL_ESTATE = 'Real Estate';
    case ENTERTAINMENT = 'Entertainment';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
