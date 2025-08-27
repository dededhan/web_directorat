<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::table('produk_inovasi', function (Blueprint $table) {
            // Tambahkan kolom 'kategori' setelah kolom 'nomor_paten'
            $table->string('kategori')->after('nomor_paten');

            // Tambahkan kolom 'link_ebook' setelah kolom 'kategori', dan boleh kosong (nullable)
            $table->string('link_ebook')->nullable()->after('kategori');
        });
    }


    public function down(): void
    {
        Schema::table('produk_inovasi', function (Blueprint $table) {
            // Hapus kolom jika migration di-rollback
            $table->dropColumn(['kategori', 'link_ebook']);
        });
    }
};