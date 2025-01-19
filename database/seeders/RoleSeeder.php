<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role
        Role::create(['name' => 'admin']);

        // Create member role
        Role::create(['name' => 'member']);
    }
}
