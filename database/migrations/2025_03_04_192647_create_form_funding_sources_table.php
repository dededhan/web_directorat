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
        Schema::create('form_funding_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('innovator_form_id')->constrained();
            $table->string('tahun_ke');
            $table->decimal('total_dana', 15, 2)->nullable();
            $table->string('sumber_dana');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_funding_sources');
    }
};
