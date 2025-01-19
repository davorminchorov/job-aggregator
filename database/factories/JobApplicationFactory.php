<?php

namespace Database\Factories;

use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'job_position_id' => JobPosition::factory(),
            'status' => fake()->randomElement([
                'pending',
                'reviewing',
                'interviewing',
                'offered',
                'hired',
                'rejected'
            ]),
            'cover_letter' => fake()->paragraphs(3, true),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function reviewing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reviewing',
        ]);
    }

    public function interviewing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'interviewing',
        ]);
    }

    public function offered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'offered',
        ]);
    }

    public function hired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'hired',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
