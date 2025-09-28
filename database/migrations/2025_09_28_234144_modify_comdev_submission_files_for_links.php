<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comdev_submission_files', function (Blueprint $table) {
            // Tambah kolom baru
            $table->enum('type', ['file', 'link'])->default('file')->after('user_id');
            $table->text('url')->nullable()->after('original_filename');

            // Ubah kolom lama agar bisa kosong (nullable)
            $table->string('file_path')->nullable()->change();
            $table->string('original_filename')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('comdev_submission_files', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['type', 'url']);

            // Kembalikan seperti semula (jika perlu)
            $table->string('file_path')->nullable(false)->change();
            $table->string('original_filename')->nullable(false)->change();
        });
    }
};