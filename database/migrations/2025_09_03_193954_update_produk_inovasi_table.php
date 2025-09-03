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
            
            // Menambahkan kolom baru setelah 'gambar'
            $table->string('foto_poster')->nullable()->after('gambar');
            $table->enum('video_type', ['youtube', 'mp4'])->nullable()->after('foto_poster');
            $table->string('video_path')->nullable()->after('video_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_inovasi', function (Blueprint $table) {
            // Mengembalikan tipe data kolom inovator jika di rollback
            $table->string('inovator')->change();

            // Menghapus kolom yang ditambahkan
            $table->dropColumn(['foto_poster', 'video_type', 'video_path']);
        });
    }
};