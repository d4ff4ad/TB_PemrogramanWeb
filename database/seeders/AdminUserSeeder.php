<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@eventify.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@eventify.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
