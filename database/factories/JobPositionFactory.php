<?php

namespace Database\Factories;

use App\Enums\JobPositionBenefitName;
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
            'category_id' => Category::query()->inRandomOrder()->first()->id,
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'requirements' => $this->generateRequirements(),
            'benefits' => $this->generateBenefits(),
            'salary_min' => $salaryMin,
            'salary_max' => fake()->numberBetween($salaryMin, $salaryMin + 100000),
            'location' => fake()->randomElement([fake()->city.', '.fake()->stateAbbr, 'Remote']),
            'type' => fake()->randomElement(JobType::values()),
        ];
    }

    protected function generateRequirements(): string
    {
        $requirements = [];
        $numRequirements = fake()->numberBetween(4, 7);

        $experienceYears = fake()->numberBetween(2, 8);
        $requirements[] = "$experienceYears+ years of relevant experience";

        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'React', 'Vue.js', 'Node.js',
            'Python', 'Java', 'Docker', 'Kubernetes', 'AWS', 'GCP', 'Azure',
            'SQL', 'NoSQL', 'Redis', 'MongoDB', 'GraphQL', 'REST APIs',
            'CI/CD', 'Git', 'Agile methodologies', 'TDD', 'System Design',
        ];

        for ($i = 0; $i < $numRequirements - 1; $i++) {
            $requirements[] = 'Experience with '.fake()->randomElement($skills);
        }

        return implode("\n", array_map(fn ($req) => "- $req", $requirements));
    }

    protected function generateBenefits(): string
    {
        $benefits = fake()->randomElements(JobPositionBenefitName::values(), fake()->numberBetween(5, 8));

        return implode("\n", array_map(fn ($benefit) => "- $benefit", $benefits));
    }
}
