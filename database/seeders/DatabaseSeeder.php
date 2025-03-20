<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::factory()->create([
            'name' => 'Ernest Haruna',
            'email' => 'ernest@owenahub.com',
            'account_type' => 'admin',
            'email_verified_at' => now(),
            'password' => "qwerty123$*",
        ]);

        $user->mentor_profile()->create([
            'status' => 'active',
            'is_verified' => true
        ]);
    }
}
