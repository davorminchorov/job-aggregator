<?php

namespace App\Enums;

enum RoleName: string
{
    case MEMBER = 'member';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::MEMBER => 'Member',
            self::ADMIN => 'Administrator',
        };
    }
}
