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
        // Add English columns to beritas table
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('judul_en', 200)->nullable()->after('judul');
            $table->text('isi_en')->nullable()->after('isi');
        });

        // Add English columns to pengumumans table
        Schema::table('pengumumans', function (Blueprint $table) {
            $table->string('judul_pengumuman_en', 50)->nullable()->after('judul_pengumuman');
            $table->text('isi_pengumuman_en')->nullable()->after('isi_pengumuman');
        });

        // Add English columns to program_layanans table
        Schema::table('program_layanans', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['judul_en', 'isi_en']);
        });

        Schema::table('pengumumans', function (Blueprint $table) {
            $table->dropColumn(['judul_pengumuman_en', 'isi_pengumuman_en']);
        });

        Schema::table('program_layanans', function (Blueprint $table) {
            $table->dropColumn(['judul_en', 'deskripsi_en']);
        });
    }
};
