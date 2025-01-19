<?php

namespace Database\Factories;

use App\Models\JobPositionSourceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPositionSource>
 */
class JobPositionSourceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'job_position_source_type_id' => JobPositionSourceType::factory(),
            'name' => fake()->company() . ' Jobs Feed',
            'credentials' => [],
            'is_active' => true,
            'last_synced_at' => null,
        ];
    }
}
