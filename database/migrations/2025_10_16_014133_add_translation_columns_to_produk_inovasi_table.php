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
        Schema::table('produk_inovasi', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('produk_inovasi', 'nama_produk_en')) {
                $table->string('nama_produk_en')->nullable()->after('nama_produk');
            }
            if (!Schema::hasColumn('produk_inovasi', 'inovator_en')) {
                $table->string('inovator_en')->nullable()->after('inovator');
            }
            if (!Schema::hasColumn('produk_inovasi', 'deskripsi_en')) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_inovasi', function (Blueprint $table) {
            $table->dropColumn(['nama_produk_en', 'inovator_en', 'deskripsi_en']);
        });
    }
};
