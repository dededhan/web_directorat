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
        if (Schema::hasTable('innovator_forms')) {
            return;
        }

        Schema::create('innovator_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_penanggungjawab');
            $table->string('institusi');
            $table->text('alamat_kontak');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('judul_inovasi');
            $table->string('nama_program');
            $table->string('jenis_inovasi');
            $table->string('jenis_lainnya')->nullable();
            $table->string('bidang_inovasi');
            $table->string('bidang_lainnya')->nullable();
            $table->text('aplikasi_manfaat');
            $table->string('lama_program');
            $table->string('tahun_berjalan');
            $table->longText('ringkasan_inovasi');
            $table->longText('kebaruan');
            $table->longText('keunggulan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('innovator_forms');
    }
};
