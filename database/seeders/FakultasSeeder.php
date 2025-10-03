<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <-- Tambahkan ini
use Carbon\Carbon;

class FakultasSeeder extends Seeder
{
    public function run()
    {

        Schema::disableForeignKeyConstraints();


        DB::table('equity_fakultas')->truncate();

        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        $fakultasData = [
            ['id' => 1, 'name' => 'Fakultas Ilmu Pendidikan', 'abbreviation' => 'FIP', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Fakultas Bahasa dan Seni', 'abbreviation' => 'FBS', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'abbreviation' => 'FMIPA', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Fakultas Ilmu Sosial dan Hukum', 'abbreviation' => 'FISH', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Fakultas Teknik', 'abbreviation' => 'FT', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name' => 'Fakultas Ilmu Keolahragaan dan Kesehatan', 'abbreviation' => 'FIK', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name' => 'Fakultas Ekonomi dan Bisnis', 'abbreviation' => 'FEB', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name' => 'Fakultas Psikologi', 'abbreviation' => 'FPSI', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'name' => 'Pascasarjana', 'abbreviation' => 'PsS', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'name' => 'Program Profesi', 'abbreviation' => 'profesi', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Menggunakan insert biasa karena tabel sudah kosong
        DB::table('equity_fakultas')->insert($fakultasData);
    }
}
