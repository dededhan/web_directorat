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
        Schema::create('comdev_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comdev_proposal_id')->constrained('proposal_sessions')->onDelete('cascade');
            $table->string('nama_modul');
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comdev_modules');
    }
};
