<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement("ALTER TABLE apc_submissions MODIFY COLUMN status ENUM('diajukan', 'verifikasi', 'disetujui', 'verifikasi pembayaran', 'revisi', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        DB::statement("ALTER TABLE apc_submissions MODIFY COLUMN status ENUM('diajukan', 'verifikasi', 'disetujui', 'revisi', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");
    }
};