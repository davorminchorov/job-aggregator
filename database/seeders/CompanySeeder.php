<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 startup companies
        Company::factory()
            ->count(5)
            ->startup()
            ->create();

        // Create 5 enterprise companies
        Company::factory()
            ->count(5)
            ->enterprise()
            ->create();

        // Create 10 random companies
        Company::factory()
            ->count(10)
            ->create();
    }
}
