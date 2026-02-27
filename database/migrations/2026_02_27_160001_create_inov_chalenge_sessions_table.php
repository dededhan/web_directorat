<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->text('deskripsi')->nullable();
            $table->decimal('dana_maksimal', 15, 2)->nullable();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->unsignedTinyInteger('min_anggota')->default(1);
            $table->unsignedTinyInteger('max_anggota')->default(4);
            $table->enum('status', ['draft', 'active', 'closed'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_sessions');
    }
};
