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
        Schema::table('proposal_modul', function (Blueprint $table) {
            // Add new fields after existing columns
            $table->string('tahun_usulan', 4)->nullable()->after('ringkasan_modul');
            $table->string('tahun_pelaksanaan', 4)->nullable()->after('tahun_usulan');
            $table->string('tempat_pelaksanaan')->nullable()->after('tahun_pelaksanaan');
            
            // Replace sdgs with sdgs_fokus and sdgs_pendukung
            $table->json('sdgs_fokus')->nullable()->after('kata_kunci');
            $table->json('sdgs_pendukung')->nullable()->after('sdgs_fokus');
            
            // Add financial and platform fields
            $table->decimal('anggaran_usulan', 15, 2)->nullable()->after('tempat_pelaksanaan');
            $table->string('platform_digital')->nullable()->after('anggaran_usulan');
            $table->string('mitra')->nullable()->after('platform_digital');
            
            // Add status fields
            $table->enum('modul_interdisiplin', ['Ada', 'Draft'])->nullable()->after('mitra');
            $table->enum('publikasi_media_massa', ['Ada', 'Draft'])->nullable()->after('modul_interdisiplin');
            $table->string('nama_media_massa')->nullable()->after('publikasi_media_massa');
            $table->enum('hki', ['Ada', 'Draft'])->nullable()->after('nama_media_massa');
            $table->text('jenis_hki_dan_judul')->nullable()->after('hki');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_modul', function (Blueprint $table) {
            $table->dropColumn([
                'tahun_usulan',
                'tahun_pelaksanaan',
                'tempat_pelaksanaan',
                'sdgs_fokus',
                'sdgs_pendukung',
                'anggaran_usulan',
                'platform_digital',
                'mitra',
                'modul_interdisiplin',
                'publikasi_media_massa',
                'nama_media_massa',
                'hki',
                'jenis_hki_dan_judul',
            ]);
        });
    }
};
