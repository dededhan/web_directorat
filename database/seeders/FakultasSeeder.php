<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FakultasSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $fakultasData = [
            ['id' => 1, 'name' => 'Fakultas Ilmu Pendidikan', 'abbreviation' => 'FIP', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Fakultas Bahasa dan Seni', 'abbreviation' => 'FBS', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'abbreviation' => 'FMIPA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Fakultas Ilmu Sosial', 'abbreviation' => 'FIS', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Fakultas Teknik', 'abbreviation' => 'FT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Fakultas Ilmu Keolahragaan', 'abbreviation' => 'FIK', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => 'Fakultas Ekonomi', 'abbreviation' => 'FE', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name' => 'Fakultas Pendidikan Psikologi', 'abbreviation' => 'FPPsi', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'name' => 'Pascasarjana', 'abbreviation' => 'PsS', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'name' => 'Program Profesi', 'abbreviation' => 'profesi', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($fakultasData as $fakultas) {
            DB::table('equity_fakultas')->updateOrInsert(
                ['id' => $fakultas['id']], // Kolom unik untuk dicek
                $fakultas // Data untuk di-insert atau di-update
            );
        }
    }
}