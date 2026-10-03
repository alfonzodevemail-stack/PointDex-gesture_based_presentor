<?php

namespace Database\Seeders;

use App\Models\Presentation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a default presenter account for easy login
        $defaultUser = User::firstOrCreate(
            ['email' => 'presenter@pointdex.com'],
            [
                'name' => 'Alfonzo Balagapo',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Generate 12 sample presentation records using Faker (exceeds the 10-record requirement)
        Presentation::factory()->count(12)->create([
            'user_id' => $defaultUser->id,
        ]);
    }
}