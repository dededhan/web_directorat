<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::create('matchmaking_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matchmaking_session_id')->constrained('matchmaking_sessions')->onDelete('cascade');
            

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('judul_proposal');
            $table->string('status')->default('diajukan');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('matchmaking_submissions');
    }
};
