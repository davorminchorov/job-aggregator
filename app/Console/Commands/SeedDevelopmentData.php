<?php

namespace App\Console\Commands;

use Database\Seeders\DevelopmentSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class SeedDevelopmentData extends Command
{
    protected $signature = 'app:seed-dev';

    protected $description = 'Seed the database with development data';

    public function handle(): int
    {
        if (!App::environment('local')) {
            $this->error('This command can only be run in the local environment!');
            return self::FAILURE;
        }

        $this->info('Seeding development data...');
        $this->call('db:seed', ['--class' => DevelopmentSeeder::class]);

        $this->info('Development data seeded successfully!');
        $this->info('You can login as admin with:');
        $this->info('Email: admin@example.com');
        $this->info('Password: password');

        return self::SUCCESS;
    }
}
