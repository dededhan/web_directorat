<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InovChalengeAccountSeeder extends Seeder
{
    /**
     * Seed reviewer_inovchalenge and alumni accounts for Innovation Challenge.
     */
    public function run(): void
    {
        $this->command->info('Seeding Innovation Challenge accounts...');

        // ── Reviewer accounts ────────────────────────────────────────────
        $reviewers = [
            ['name' => 'Reviewer IC 1', 'email' => 'reviewer.ic1@unj.ac.id'],
            ['name' => 'Reviewer IC 2', 'email' => 'reviewer.ic2@unj.ac.id'],
            ['name' => 'Reviewer IC 3', 'email' => 'reviewer.ic3@unj.ac.id'],
        ];

        foreach ($reviewers as $reviewer) {
            User::updateOrCreate(
                ['email' => $reviewer['email']],
                [
                    'name' => $reviewer['name'],
                    'password' => Hash::make($reviewer['email']),
                    'role' => 'reviewer_inovchalenge',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('  ✓ ' . count($reviewers) . ' reviewer_inovchalenge accounts created');

        // ── Alumni accounts ──────────────────────────────────────────────
        $alumni = [
            ['name' => 'Alumni IC 1', 'email' => 'alumni.ic1@unj.ac.id'],
            ['name' => 'Alumni IC 2', 'email' => 'alumni.ic2@unj.ac.id'],
            ['name' => 'Alumni IC 3', 'email' => 'alumni.ic3@unj.ac.id'],
        ];

        foreach ($alumni as $alum) {
            User::updateOrCreate(
                ['email' => $alum['email']],
                [
                    'name' => $alum['name'],
                    'password' => Hash::make($alum['email']),
                    'role' => 'alumni',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('  ✓ ' . count($alumni) . ' alumni accounts created');
        $this->command->info('Done! Password = email address for all accounts.');
    }
}
