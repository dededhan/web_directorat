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
        Schema::create('sejarah_contents', function (Blueprint $table) {
            $table->id();
            $table->string('category')->comment('pemeringkatan or inovasi');
            $table->string('section')->comment('sejarah, visi-misi, tujuan, rencana');
            $table->longText('content');
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            // Create a unique index on category and section to ensure each combo is unique
            $table->unique(['category', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sejarah_contents');
    }
};