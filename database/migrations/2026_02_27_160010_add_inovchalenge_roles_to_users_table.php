<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Full role list at time of this migration (last update: add_sub_admin_equity)
    // plus new roles: alumni, reviewer_inovchalenge
    private array $newRoles = [
        'super_admin',
        'admin_direktorat',
        'admin_pemeringkatan',
        'admin_inovasi',
        'admin_hilirisasi',
        'kepala_direktorat',
        'fakultas',
        'prodi',
        'dosen',
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
        'alumni',               // NEW — needed for InovChalenge team member approval
        'reviewer_inovchalenge', // NEW — reviewer role for InovChalenge
    ];

    private array $previousRoles = [
        'super_admin',
        'admin_direktorat',
        'admin_pemeringkatan',
        'admin_inovasi',
        'admin_hilirisasi',
        'kepala_direktorat',
        'fakultas',
        'prodi',
        'dosen',
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
    ];

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', $this->newRoles)->default('registered_user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', $this->previousRoles)->default('registered_user')->change();
        });
    }
};
