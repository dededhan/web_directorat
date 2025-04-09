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
        Schema::create('katsinov_informasi_collections', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->integer('index');
            $table->string('attribute');
            $table->string('value');
            $table->foreignId('katsinov_informasi_id')->references('id')->on('katsinov_informasis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_informasi_collections');
    }
};
