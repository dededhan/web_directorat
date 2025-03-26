<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_layanans', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('judul');
            $table->text('deskripsi');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_layanans');
    }
};