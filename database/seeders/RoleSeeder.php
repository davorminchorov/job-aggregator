<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role
        Role::create(['name' => RoleName::ADMIN->value]);

        // Create member role
        Role::create(['name' => RoleName::MEMBER->value]);
    }
}
