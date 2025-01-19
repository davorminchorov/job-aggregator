<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing users and job positions
        $users = User::all();
        $jobPositions = JobPosition::all();

        // Create some applications for each user
        foreach ($users as $user) {
            // Random number of applications per user (1-3)
            $numApplications = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $numApplications; $i++) {
                JobApplication::factory()
                    ->create([
                        'user_id' => $user->id,
                        'job_position_id' => $jobPositions->random()->id,
                    ]);
            }
        }

        // Create some applications in specific states
        JobApplication::factory()
            ->count(3)
            ->pending()
            ->create([
                'user_id' => $users->random()->id,
                'job_position_id' => $jobPositions->random()->id,
            ]);

        JobApplication::factory()
            ->count(2)
            ->reviewing()
            ->create([
                'user_id' => $users->random()->id,
                'job_position_id' => $jobPositions->random()->id,
            ]);

        JobApplication::factory()
            ->count(2)
            ->interviewing()
            ->create([
                'user_id' => $users->random()->id,
                'job_position_id' => $jobPositions->random()->id,
            ]);

        JobApplication::factory()
            ->count(1)
            ->offered()
            ->create([
                'user_id' => $users->random()->id,
                'job_position_id' => $jobPositions->random()->id,
            ]);

        JobApplication::factory()
            ->count(1)
            ->hired()
            ->create([
                'user_id' => $users->random()->id,
                'job_position_id' => $jobPositions->random()->id,
            ]);

        JobApplication::factory()
            ->count(2)
            ->rejected()
            ->create([
                'user_id' => $users->random()->id,
                'job_position_id' => $jobPositions->random()->id,
            ]);
    }
}
