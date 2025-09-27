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
        Schema::create('apc_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apc_submission_id')->constrained('apc_submissions')->onDelete('cascade');
            $table->integer('urutan');
            $table->string('nama');
            $table->string('afiliasi');
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
        Schema::dropIfExists('apc_authors');
    }
};
