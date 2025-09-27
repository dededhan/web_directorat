<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {

        Schema::create('matchmaking_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('matchmaking_submission_id')->constrained('matchmaking_submissions')->onDelete('cascade');


            $table->string('type');
            

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->json('details')->nullable();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('matchmaking_members');
    }
};

