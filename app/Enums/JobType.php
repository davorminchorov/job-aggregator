<?php

namespace App\Enums;

enum JobType: string
{
    case FULL_TIME = 'full-time';
    case PART_TIME = 'part-time';
    case CONTRACT = 'contract';
    case FREELANCE = 'freelance';
    case INTERNSHIP = 'internship';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full-time',
            self::PART_TIME => 'Part-time',
            self::CONTRACT => 'Contract',
            self::FREELANCE => 'Freelance',
            self::INTERNSHIP => 'Internship',
        };
    }
}
