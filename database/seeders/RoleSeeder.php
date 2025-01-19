<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        if (! Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        if (! Role::where('name', 'member')->exists()) {
            Role::create(['name' => 'member']);
        }
    }
}
