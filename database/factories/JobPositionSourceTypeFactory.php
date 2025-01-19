<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPositionSourceType>
 */
class JobPositionSourceTypeFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        return [
            'name' => $name,
            'key' => Str::slug($name),
            'description' => fake()->sentence(),
            'required_fields' => [
                'api_key' => 'string',
                'endpoint' => 'string',
            ],
            'is_active' => true,
        ];
    }
}
