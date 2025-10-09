<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement("ALTER TABLE employer_meeting_submissions MODIFY COLUMN status ENUM('diajukan', 'menunggu diverifikasi', 'diverifikasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'diajukan'");
        \DB::statement("ALTER TABLE joint_supervision_submissions MODIFY COLUMN status ENUM('diajukan', 'menunggu diverifikasi', 'diverifikasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'diajukan'");
        \DB::statement("ALTER TABLE visiting_professor_submissions MODIFY COLUMN status ENUM('diajukan', 'menunggu diverifikasi', 'diverifikasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("ALTER TABLE employer_meeting_submissions MODIFY COLUMN status ENUM('diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'diajukan'");
        \DB::statement("ALTER TABLE joint_supervision_submissions MODIFY COLUMN status ENUM('diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'diajukan'");
        \DB::statement("ALTER TABLE visiting_professor_submissions MODIFY COLUMN status ENUM('diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'diajukan'");
    }
};
