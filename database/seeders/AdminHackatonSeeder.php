<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminHackatonSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('HACKATON_ADMIN_EMAIL', 'admin.hackaton@unj.ac.id');
        $password = env('HACKATON_ADMIN_PASSWORD');

        if (! $password) {
            $this->command?->warn('Skipping Hackaton admin seed: HACKATON_ADMIN_PASSWORD is not configured.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Hackaton',
                'password' => Hash::make($password),
                'role' => 'admin_hackaton',
                'status' => 'active',
                'email_verified_at' => now(),
            ],
        );

        $this->command?->info("Hackaton admin account ready: {$email}");
    }
}