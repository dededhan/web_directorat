<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE inov_chalenge_submission_members MODIFY tipe_anggota ENUM('dosen','tendik','alumni','DUDI','mahasiswa','PPPK','peneliti') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE inov_chalenge_submission_members MODIFY tipe_anggota ENUM('dosen','alumni','DUDI','mahasiswa','PPPK','peneliti') NOT NULL");
    }
};
