<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('the_impact_sdgs', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('color', 7)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('the_impact_sdgs');
    }
};
