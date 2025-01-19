<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Davor Minchorov',
            'email' => 'davorminchorov@gmail.com',
        ]);

        $admin->assignRole(RoleName::ADMIN->value);

        // Create member user
        $member = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $member->assignRole(RoleName::MEMBER->value);
    }
}
