<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    public function run(): void
    {
        JobPosition::factory()->count(50)->create();
    }
}
