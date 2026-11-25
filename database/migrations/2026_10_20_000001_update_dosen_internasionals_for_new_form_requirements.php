<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->string('fakultas')->nullable()->change();
            $table->string('prodi')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('bidang_keahlian')->nullable()->change();
            if (!Schema::hasColumn('dosen_internasionals', 'link_bukti_kegiatan')) {
                $table->text('link_bukti_kegiatan')->nullable()->after('sesi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            if (Schema::hasColumn('dosen_internasionals', 'link_bukti_kegiatan')) {
                $table->dropColumn('link_bukti_kegiatan');
            }
        });
    }
};
