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
        Schema::create('produk_inovasi_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_inovasi_id')->constrained('produk_inovasi')->onDelete('cascade');
            $table->enum('type', ['youtube', 'mp4']);
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_inovasi_videos');
    }
};