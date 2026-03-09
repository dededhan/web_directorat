<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminInovChalengeSeeder extends Seeder
{
    /**
     * Seed the admin_inovchalenge account.
     */
    public function run(): void
    {
        $this->command->info('Seeding Admin InovChallenge account...');

        User::updateOrCreate(
            ['email' => 'admin.inovchalenge@unj.ac.id'],
            [
                'name'              => 'Admin InovChallenge',
                'password'          => Hash::make('inovchalenge123'),
                'role'              => 'admin_inovchalenge',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('  ✓ admin_inovchalenge account created (admin.inovchalenge@unj.ac.id / inovchalenge123)');
    }
}
