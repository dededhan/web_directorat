<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rename existing 'eksternal' rows to 'DUDI'
        DB::table('inov_chalenge_submission_members')
            ->where('tipe_anggota', 'eksternal')
            ->update(['tipe_anggota' => 'DUDI']);

        // 2. Alter enum to include new types
        DB::statement("ALTER TABLE inov_chalenge_submission_members MODIFY tipe_anggota ENUM('dosen','alumni','DUDI','mahasiswa','PPPK') NOT NULL");

        // 3. Update approval_status for existing DUDI records (previously not_required for eksternal)
        DB::table('inov_chalenge_submission_members')
            ->where('tipe_anggota', 'DUDI')
            ->where('approval_status', 'not_required')
            ->where('peran', '!=', 'Ketua')
            ->update(['approval_status' => 'pending']);
    }

    public function down(): void
    {
        // Revert DUDI back to eksternal
        DB::table('inov_chalenge_submission_members')
            ->where('tipe_anggota', 'DUDI')
            ->update(['tipe_anggota' => 'eksternal']);

        DB::statement("ALTER TABLE inov_chalenge_submission_members MODIFY tipe_anggota ENUM('dosen','alumni','eksternal') NOT NULL");
    }
};
