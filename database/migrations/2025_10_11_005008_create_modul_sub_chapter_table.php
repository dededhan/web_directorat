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
        Schema::create('modul_sub_chapter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_akhir_id')->constrained('modul_akhir')->onDelete('cascade');
            $table->string('judul_sub_chapter');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_input', ['pdf', 'link', 'pdf_atau_link'])->default('pdf');
            $table->boolean('is_wajib')->default(true);
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_sub_chapter');
    }
};
