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
        Schema::create('katsinov_beritas', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->string('date');
            $table->string('month');
            $table->string('year');
            $table->string('yearfull');
            $table->string('place');
            $table->string('decree');
            $table->string('title');
            $table->string('type');
            $table->string('tki');
            $table->string('opinion');
            $table->date('sign_date');
            $table->foreignId('katsinov_id')->references('id')->on('katsinovs');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_beritas');
    }
};
