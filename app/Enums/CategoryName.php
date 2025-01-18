<?php

namespace App\Enums;

enum CategoryName: string
{
    case BACKEND_DEVELOPMENT = 'Backend Development';
    case FRONTEND_DEVELOPMENT = 'Frontend Development';
    case FULL_STACK_DEVELOPMENT = 'Full Stack Development';
    case DEVOPS = 'DevOps';
    case MOBILE_DEVELOPMENT = 'Mobile Development';
    case DATA_SCIENCE = 'Data Science';
    case UI_UX_DESIGN = 'UI/UX Design';
    case QA_TESTING = 'QA & Testing';
    case PROJECT_MANAGEMENT = 'Project Management';
    case SECURITY = 'Security';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
