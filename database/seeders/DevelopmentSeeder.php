<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosition;
use App\Models\JobPositionSource;
use App\Models\JobPositionSourceType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(RoleName::ADMIN->value);

        // Create regular users
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole(RoleName::MEMBER->value);
        });

        // Create companies with job positions
        Company::factory(20)->create()->each(function ($company) {
            // Create 3-8 job positions for each company
            $positions = JobPosition::factory(fake()->numberBetween(3, 8))->create([
                'company_id' => $company->id,
                'category_id' => Category::inRandomOrder()->first()->id,
            ]);

            // Randomly mark some positions as filled
            $positions->random(fake()->numberBetween(0, 2))->each(function ($position) {
                $position->update(['is_filled' => true]);
            });
        });
    }
}
