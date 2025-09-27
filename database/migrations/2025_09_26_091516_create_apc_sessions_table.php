<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apc_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->text('deskripsi')->nullable();
            $table->bigInteger('dana')->unsigned();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->enum('status', ['Buka', 'Tutup'])->default('Buka');
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
        Schema::dropIfExists('apc_sessions');
    }
};
