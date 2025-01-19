<?php

namespace Database\Seeders;

use App\Models\JobPositionSourceType;
use Illuminate\Database\Seeder;

class JobPositionSourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobPositionSourceType::create([
            'name' => 'Airtable',
            'key' => 'airtable',
            'description' => 'Import job positions from Airtable bases',
            'required_fields' => [
                'api_key' => 'string',
                'base_id' => 'string',
                'table_id' => 'string',
            ],
            'is_active' => true,
        ]);

        JobPositionSourceType::create([
            'name' => 'Telegram',
            'key' => 'telegram',
            'description' => 'Import job positions from Telegram groups or channels',
            'required_fields' => [
                'bot_token' => 'string',
                'chat_id' => 'string',
            ],
            'is_active' => true,
        ]);
    }
}
