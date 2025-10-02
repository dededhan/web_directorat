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
        // Mengubah kolom-kolom alamat menjadi BOLEH KOSONG (nullable)
        Schema::table('proposal_members', function (Blueprint $table) {
            $table->string('alamat_jalan')->nullable()->change();
            $table->string('provinsi')->nullable()->change();
            $table->string('kota_kabupaten')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('kelurahan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kode ini untuk mengembalikan jika migrasi dibatalkan
        Schema::table('proposal_members', function (Blueprint $table) {
            $table->string('alamat_jalan')->nullable(false)->change();
            $table->string('provinsi')->nullable(false)->change();
            $table->string('kota_kabupaten')->nullable(false)->change();
            $table->string('kecamatan')->nullable(false)->change();
            $table->string('kelurahan')->nullable(false)->change();
        });
    }
};