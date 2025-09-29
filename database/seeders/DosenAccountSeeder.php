<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DosenAccountSeeder extends Seeder
{
    public function run()
    {
        $csvFile = fopen(database_path('seeders/data/dosen.csv'), 'r');
        if ($csvFile === false) {
            $this->command->error('File CSV tidak ditemukan di database/seeders/data/dosen.csv');
            return;
        }

        // Membaca dan melewati baris header pertama (name,email)
        fgetcsv($csvFile);

        $totalRows = count(file(database_path('seeders/data/dosen.csv'))) - 1;
        $progressBar = $this->command->getOutput()->createProgressBar($totalRows);

        $this->command->info('Memulai proses import data akun dosen...');
        $progressBar->start();

        DB::transaction(function () use ($csvFile, $progressBar) {
            while (($row = fgetcsv($csvFile)) !== false) {
                if (is_array($row) && isset($row[0]) && isset($row[1])) {
                    $name = $row[0];
                    $email = $row[1];

                    User::updateOrCreate(
                        ['email' => $email],
                        [
                            'name' => $name,
                            // UBAH DI SINI: Password adalah email itu sendiri
                            'password' => Hash::make($email),
                            'role' => 'dosen',
                            'status' => 'active',
                            'email_verified_at' => now(),
                        ]
                    );
                }
                $progressBar->advance();
            }
        });

        fclose($csvFile);
        $progressBar->finish();
        $this->command->info("\nProses import data akun dosen telah selesai.");
    }
}