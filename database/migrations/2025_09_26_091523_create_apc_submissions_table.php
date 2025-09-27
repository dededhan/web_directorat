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
        Schema::create('apc_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apc_session_id')->constrained('apc_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_jurnal_q1');
            $table->string('link_scimagojr');
            $table->string('judul_artikel');
            $table->string('volume')->nullable();
            $table->string('issue')->nullable();
            $table->bigInteger('biaya_publikasi')->unsigned();
            $table->string('artikel_path')->nullable();
            $table->string('invoice_path')->nullable();
            $table->string('submission_process_path')->nullable();
            $table->enum('status', ['diajukan', 'verifikasi', 'disetujui'])->default('diajukan');
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
        Schema::dropIfExists('apc_submissions');
    }
};
