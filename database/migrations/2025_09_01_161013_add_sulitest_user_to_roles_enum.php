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
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', [
            'super_admin',
            'admin_direktorat',
            'admin_pemeringkatan',
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
            'sulitest_user' // <-- Add the new value here
        ])->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles_enum', function (Blueprint $table) {
            //
        });
    }
};
