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
        Schema::create('katsinov_inovasis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('introduction');
            $table->string('tech_product');
            $table->string('supremacy');
            $table->string('patent');
            $table->string('tech_preparation');
            $table->string('market_preparation');
            $table->string('name');
            $table->string('phone');
            $table->string('mobile');
            $table->string('fax');
            $table->string('email');
            $table->foreignId('katsinov_id')->references('id')->on('katsinovs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_inovasis');
    }
};
