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
        Schema::create('sesi_student_exchange', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->text('deskripsi')->nullable();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->enum('status', ['dibuka', 'ditutup'])->default('dibuka');
            $table->timestamps();

            // Indexes for performance
            $table->index('status');
            $table->index('periode_awal');
            $table->index('periode_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_student_exchange');
    }
};
