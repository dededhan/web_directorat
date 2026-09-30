<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $newRoles = [
        'super_admin',
        'admin_direktorat',
        'admin_pemeringkatan',
        'admin_inovasi',
        'admin_inovchalenge',
        'admin_hackaton',
        'admin_hilirisasi',
        'kepala_direktorat',
        'fakultas',
        'prodi',
        'dosen',
        'tendik',
        'kepala_sub_direktorat',
        'wr3',
        'mahasiswa',
        'validator',
        'registered_user',
        'sulitest_user',
        'admin_equity',
        'sub_admin_equity',
        'reviewer_equity',
        'reviewer_hibah',
        'equity_fakultas',
        'alumni',
        'reviewer_inovchalenge',
        'peneliti',
        'dudi',
        'pppk',
        'hackaton_dosen',
        'hackaton_dosen_eksternal',
        'hackaton_tendik',
        'hackaton_alumni',
        'hackaton_peneliti',
        'hackaton_dudi',
        'hackaton_pppk',
        'hackaton_mahasiswa',
        'reviewer_hackaton',
    ];

    private array $previousRoles = [
        'super_admin',
        'admin_direktorat',
        'admin_pemeringkatan',
        'admin_inovasi',
        'admin_inovchalenge',
        'admin_hackaton',
        'admin_hilirisasi',
        'kepala_direktorat',
        'fakultas',
        'prodi',
        'dosen',
        'tendik',
        'kepala_sub_direktorat',
        'wr3',
        'mahasiswa',
        'validator',
        'registered_user',
        'sulitest_user',
        'admin_equity',
        'sub_admin_equity',
        'reviewer_equity',
        'reviewer_hibah',
        'equity_fakultas',
        'alumni',
        'reviewer_inovchalenge',
        'peneliti',
        'dudi',
        'pppk',
        'hackaton_dosen',
        'hackaton_tendik',
        'hackaton_alumni',
        'hackaton_peneliti',
        'hackaton_dudi',
        'hackaton_pppk',
        'hackaton_mahasiswa',
        'reviewer_hackaton',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update users.role enum
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', $this->newRoles)->default('registered_user')->change();
        });

        // 2. Update hackaton_registrations.role enum
        DB::statement("ALTER TABLE hackaton_registrations MODIFY COLUMN role ENUM('dosen','dosen_eksternal','tendik','alumni','peneliti','dudi','pppk','mahasiswa') NOT NULL");

        // 3. Update hackaton_submission_members.tipe_anggota enum
        DB::statement("ALTER TABLE hackaton_submission_members MODIFY COLUMN tipe_anggota ENUM('dosen','dosen_eksternal','alumni','DUDI','mahasiswa','PPPK','peneliti','tendik') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', $this->previousRoles)->default('registered_user')->change();
        });

        DB::statement("ALTER TABLE hackaton_registrations MODIFY COLUMN role ENUM('dosen','tendik','alumni','peneliti','dudi','pppk','mahasiswa') NOT NULL");
        DB::statement("ALTER TABLE hackaton_submission_members MODIFY COLUMN tipe_anggota ENUM('dosen','alumni','DUDI','mahasiswa','PPPK','peneliti','tendik') NOT NULL");
    }
};
