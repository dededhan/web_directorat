<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core data first (no dependencies)
            UsersSeeder::class,
            RolesAndPermissionsSeeder::class,

            // Foundation data - HARUS SEBELUM PesertaSeeder
            FakultasSeeder::class,           // Mengisi equity_fakultas table
            ProdiSeeder::class,              // Mengisi equity_prodi table
            KatsinovCategoriesSeeder::class,  // Mengisi katsinov_categories table

            // Data that depends on foundation
            KatsinovIndicatorsSeeder::class,  // Bergantung pada katsinov_categories

            // Additional data
            EmailTemplateSeeder::class,
            RespondenSeeder::class,
            RespondenAnswerSeeder::class,
            QuesionerGeneralSeeder::class,

            // Data that depends on users and fakultas/prodi
            EquityFakultasSeeder::class,    // Bergantung pada Fakultas model dan UsersSeeder
            PesertaSeeder::class,            // Bergantung pada equity_fakultas dan equity_prodi

            // Test data (last)
            ValidatorTestSeeder::class,
        ]);
    }
}
