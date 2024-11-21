<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'registration_enabled',
            'value' => true, // Default is true, meaning registration is enabled
        ]);
    }
}