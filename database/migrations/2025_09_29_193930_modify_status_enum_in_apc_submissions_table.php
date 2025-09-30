<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menambahkan 'revisi' dan 'selesai' ke dalam daftar ENUM
        DB::statement("ALTER TABLE apc_submissions MODIFY COLUMN status ENUM('diajukan', 'verifikasi', 'disetujui', 'revisi', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Mengembalikan ke definisi ENUM sebelumnya jika diperlukan rollback
        DB::statement("ALTER TABLE apc_submissions MODIFY COLUMN status ENUM('diajukan', 'verifikasi', 'disetujui', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }
};