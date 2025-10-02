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
    Schema::create('fee_reviewer_sessions', function (Blueprint $table) {
        $table->id();
        $table->string('nama_sesi');
        $table->text('deskripsi')->nullable();
        $table->date('periode_awal');
        $table->date('periode_akhir');
        $table->string('status')->default('dibuka');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_reviewer_sessions');
    }
};
