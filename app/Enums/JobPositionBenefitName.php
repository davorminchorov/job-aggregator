<?php

namespace App\Enums;

enum JobPositionBenefitName: string
{
    case COMPETITIVE_SALARY = 'Competitive salary';
    case REMOTE_WORK = 'Remote work options';
    case FLEXIBLE_HOURS = 'Flexible working hours';
    case HEALTH_INSURANCE = 'Health insurance';
    case DENTAL_INSURANCE = 'Dental insurance';
    case VISION_INSURANCE = 'Vision insurance';
    case RETIREMENT_401K = '401(k) matching';
    case STOCK_OPTIONS = 'Stock options';
    case PROFESSIONAL_DEVELOPMENT = 'Professional development budget';
    case CONFERENCE_ATTENDANCE = 'Conference attendance';
    case GYM_MEMBERSHIP = 'Gym membership';
    case MENTAL_HEALTH = 'Mental health benefits';
    case UNLIMITED_PTO = 'Unlimited PTO';
    case PARENTAL_LEAVE = 'Paid parental leave';
    case HOME_OFFICE = 'Home office stipend';
    case COMPANY_RETREATS = 'Company retreats';
    case LEARNING_DEVELOPMENT = 'Learning and development';
    case PERFORMANCE_BONUS = 'Performance bonuses';
    case COMPANY_EQUITY = 'Company equity';
    case PUBLIC_TRANSIT = 'Public transit benefits';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
