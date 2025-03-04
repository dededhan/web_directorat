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
        Schema::create('form_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('innovator_form_id')->constrained();
            $table->enum('type', ['technology', 'market']);
            $table->text('uraian');
            $table->enum('status', ['belum', 'sudah']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_progress');
    }
};
