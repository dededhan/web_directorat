<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Menggunakan Schema::table untuk memodifikasi tabel 'respondens' yang sudah ada
        Schema::table('respondens', function (Blueprint $table) {
            // Mengubah kolom 'nama_dosen_pengusul' agar dapat menerima nilai NULL
            // Metode ->change() diperlukan untuk menerapkan modifikasi pada kolom yang sudah ada.
            $table->string('nama_dosen_pengusul')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Metode ini akan berjalan jika Anda menjalankan perintah 'php artisan migrate:rollback'
        Schema::table('respondens', function (Blueprint $table) {
            // Mengembalikan kolom 'nama_dosen_pengusul' menjadi NOT NULL (tidak boleh kosong)
            // nullable(false) adalah kebalikan dari nullable()
            $table->string('nama_dosen_pengusul')->nullable(false)->change();
        });
    }
};
