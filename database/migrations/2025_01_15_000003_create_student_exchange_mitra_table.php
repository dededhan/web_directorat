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
        Schema::create('student_exchange_mitra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_student_exchange_id')->constrained('proposal_student_exchange')->onDelete('cascade');
            
            $table->string('nama_mitra');
            $table->string('negara');
            $table->string('nama_pic');
            $table->string('nomor_kontak_pic', 50);
            $table->string('email_pic');
            $table->string('kesediaan_mitra_path')->nullable();
            
            $table->timestamps();
            
            // Indexes and constraints
            $table->index('proposal_student_exchange_id');
            $table->unique('proposal_student_exchange_id'); // One partner per proposal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exchange_mitra');
    }
};
