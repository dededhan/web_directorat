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
        Schema::table('aktivitas_dosen_asing', function (Blueprint $table) {
            if (!Schema::hasColumn('aktivitas_dosen_asing', 'link_bukti_kegiatan')) {
                $table->text('link_bukti_kegiatan')->nullable()->after('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aktivitas_dosen_asing', function (Blueprint $table) {
            if (Schema::hasColumn('aktivitas_dosen_asing', 'link_bukti_kegiatan')) {
                $table->dropColumn('link_bukti_kegiatan');
            }
        });
    }
};

