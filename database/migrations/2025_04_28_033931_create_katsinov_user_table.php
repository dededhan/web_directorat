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
        Schema::create('katsinov_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('katsinov_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            

        });
    }
    
    public function down()
    {
        Schema::dropIfExists('katsinov_user');
    }
};
