<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Adjust the path if User model is in a custom namespace
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'fisherfresh@outlook.com'], // Check if the user exists by email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // Change to a secure password
                'role' => 'super_admin',
            ]
        );
    }
}