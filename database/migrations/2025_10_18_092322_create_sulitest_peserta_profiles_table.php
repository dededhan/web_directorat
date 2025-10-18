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
        Schema::create('sulitest_peserta_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim')->nullable()->unique();
            $table->foreignId('fakultas_id')->nullable()->constrained('equity_fakultas')->onDelete('set null');
            $table->foreignId('prodi_id')->nullable()->constrained('equity_prodi')->onDelete('set null');
            $table->timestamps();

            $table->index('user_id');
            $table->index('fakultas_id');
            $table->index('prodi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sulitest_peserta_profiles');
    }
};
