<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('matchmaking_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->text('deskripsi')->nullable();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->string('status')->default('Buka'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchmaking_sessions');
    }
};
