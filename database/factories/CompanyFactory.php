<?php

namespace Database\Factories;

use App\Enums\CompanySize;
use App\Enums\IndustryName;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(2, true),
            'website' => fake()->url(),
            'logo' => 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=818CF8&color=fff&size=400&bold=true',
            'location' => fake()->city().', '.fake()->stateAbbr(),
            'industry' => fake()->randomElement(IndustryName::values()),
            'size' => fake()->randomElement(CompanySize::values()),
            'founded_year' => fake()->year(),
            'email' => 'careers@'.Str::slug($name).'.com',
            'phone' => fake()->phoneNumber(),
        ];
    }

    /**
     * Set the company size.
     */
    public function size(string $size): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => $size,
        ]);
    }

    /**
     * Set the company as a startup (1-50 employees, founded in last 5 years).
     */
    public function startup(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => fake()->randomElement(CompanySize::startupSizes()),
            'founded_year' => fake()->year(2019),
        ]);
    }

    /**
     * Set the company as an enterprise (1000+ employees, founded more than 10 years ago).
     */
    public function enterprise(): static
    {
        return $this->state(fn (array $attributes) => [
            'size' => fake()->randomElement(CompanySize::enterpriseSizes()),
            'founded_year' => fake()->year(2013),
        ]);
    }
}
