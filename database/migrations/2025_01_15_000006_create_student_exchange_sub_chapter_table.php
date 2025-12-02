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
        Schema::create('student_exchange_sub_chapter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_exchange_modul_id')->constrained('student_exchange_modul')->onDelete('cascade');
            
            $table->string('judul_sub_chapter');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_input', ['pdf', 'link', 'both'])->default('pdf');
            $table->boolean('is_wajib')->default(true);
            $table->integer('urutan')->default(1);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('student_exchange_modul_id');
            $table->index('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exchange_sub_chapter');
    }
};
