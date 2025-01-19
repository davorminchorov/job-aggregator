<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@jobnexus.tech',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create member user
        $member = User::create([
            'name' => 'Member User',
            'email' => 'member@jobnexus.tech',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $member->assignRole('member');
    }
}
