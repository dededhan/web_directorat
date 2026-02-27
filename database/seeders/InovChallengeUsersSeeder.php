<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InovChallengeUsersSeeder extends Seeder
{
    /**
     * Seed the users table with Innovation Challenge accounts.
     */
    public function run(): void
    {
        $inovChallengeUsers = [
            [
                'name' => 'Admin Innovation Challenge',
                'email' => 'admin.inov.challenge@gmail.com',
                'password' => Hash::make('inov_challenge123'),
                'role' => 'inovchalange',
                'status' => 'active',
            ],
            [
                'name' => 'Reviewer Innovation Challenge',
                'email' => 'reviewer.inov.challenge@gmail.com',
                'password' => Hash::make('reviewer_inov123'),
                'role' => 'reviewer_inovchalange',
                'status' => 'active',
            ],
        ];

        foreach ($inovChallengeUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
