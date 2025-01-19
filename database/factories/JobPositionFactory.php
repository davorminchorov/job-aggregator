<?php

namespace Database\Factories;

use App\Enums\JobType;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPosition>
 */
class JobPositionFactory extends Factory
{
    public function definition(): array
    {
        $salaryMin = fake()->numberBetween(40000, 150000);

        return [
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'requirements' => json_encode($this->generateRequirements()),
            'benefits' => json_encode($this->generateBenefits()),
            'location' => fake()->city(),
            'type' => fake()->randomElement(JobType::cases())->value,
            'experience_level' => fake()->randomElement(['entry', 'mid', 'senior', 'lead']),
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMin + fake()->numberBetween(10000, 50000),
            'application_deadline' => fake()->dateTimeBetween('now', '+30 days'),
            'is_remote' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'is_filled' => false,
        ];
    }

    private function generateRequirements(): array
    {
        return [
            'education' => fake()->randomElement(['Bachelor\'s', 'Master\'s', 'PhD']),
            'years_of_experience' => fake()->numberBetween(1, 10),
            'skills' => fake()->words(5),
            'languages' => fake()->randomElements(['English', 'Spanish', 'French', 'German', 'Chinese'], 2),
        ];
    }

    private function generateBenefits(): array
    {
        return [
            'health_insurance' => fake()->boolean(),
            'dental_insurance' => fake()->boolean(),
            'vision_insurance' => fake()->boolean(),
            'life_insurance' => fake()->boolean(),
            '401k' => fake()->boolean(),
            'paid_time_off' => fake()->numberBetween(10, 30),
            'flexible_hours' => fake()->boolean(),
            'remote_work' => fake()->boolean(),
            'professional_development' => fake()->boolean(),
        ];
    }
}
