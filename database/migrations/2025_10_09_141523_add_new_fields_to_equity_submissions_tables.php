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
        Schema::table('employer_meeting_submissions', function (Blueprint $table) {
            $table->string('laporan_kegiatan_path')->nullable()->after('bukti_keuangan_path');
            $table->string('nama_qs_path')->nullable()->after('nama_calon_responden');
            $table->boolean('is_confirmed')->default(false)->after('status');
        });

        Schema::table('joint_supervision_submissions', function (Blueprint $table) {
            $table->string('laporan_kegiatan_path')->nullable()->after('bukti_keuangan_path');
            $table->boolean('is_confirmed')->default(false)->after('status');
        });

        Schema::table('visiting_professor_submissions', function (Blueprint $table) {
            $table->string('laporan_kegiatan_path')->nullable()->after('bukti_keuangan_path');
            $table->boolean('is_confirmed')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer_meeting_submissions', function (Blueprint $table) {
            $table->dropColumn(['laporan_kegiatan_path', 'nama_qs_path', 'is_confirmed']);
        });

        Schema::table('joint_supervision_submissions', function (Blueprint $table) {
            $table->dropColumn(['laporan_kegiatan_path', 'is_confirmed']);
        });

        Schema::table('visiting_professor_submissions', function (Blueprint $table) {
            $table->dropColumn(['laporan_kegiatan_path', 'is_confirmed']);
        });
    }
};
