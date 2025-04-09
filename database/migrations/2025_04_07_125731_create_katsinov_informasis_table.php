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
        Schema::create('katsinov_informasis', function (Blueprint $table) {
            $table->id();
            $table->string('pic');
            $table->string('institution');
            $table->string('address');
            $table->string('phone');
            $table->string('fax');
            $table->string('innovation_title');
            $table->string('innovation_name');
            $table->string('innovation_type');
            $table->string('innovation_field');
            $table->string('innovation_application');
            $table->string('innovation_duration');
            $table->string('innovation_year');
            $table->text('innovation_summary');
            $table->text('innovation_novelty');
            $table->text('innovation_supremacy');
            $table->foreignId('katsinov_id')->references('id')->on('katsinovs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_informasis');
    }
};
