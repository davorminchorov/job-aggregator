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
        // Create roles
        $this->call(RoleSeeder::class);

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

        // Create categories
        $categories = [
            'Backend Development',
            'Frontend Development',
            'Full Stack Development',
            'DevOps',
            'UI/UX Design',
            'Product Management',
            'Data Science',
            'Machine Learning',
            'Mobile Development',
            'Quality Assurance',
        ];

        foreach ($categories as $categoryName) {
            Category::factory()->create([
                'name' => $categoryName,
                'description' => fake()->paragraph(),
            ]);
        }

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

        // Create job position source types
        $this->call(JobPositionSourceTypeSeeder::class);

        // Create job position sources
        $sourceTypes = JobPositionSourceType::all();

        foreach ($sourceTypes as $sourceType) {
            JobPositionSource::factory(2)->create([
                'job_position_source_type_id' => $sourceType->id,
                'credentials' => array_combine(
                    array_keys($sourceType->required_fields),
                    array_map(fn() => fake()->uuid(), $sourceType->required_fields)
                ),
            ]);
        }

        // Create some job applications
        $users = User::role(RoleName::MEMBER->value)->get();
        $positions = JobPosition::where('is_filled', false)->get();

        foreach ($users as $user) {
            // Each user applies to 1-5 positions
            $positions->random(fake()->numberBetween(1, 5))->each(function ($position) use ($user) {
                $position->applications()->create([
                    'user_id' => $user->id,
                    'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
                ]);
            });
        }
    }
}
