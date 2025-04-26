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
        Schema::table('katsinov_beritas', function (Blueprint $table) {
            $table->string('penanggungjawab')->nullable();
            $table->string('penanggungjawab_pdf')->nullable();
            $table->string('ketua')->nullable();
            $table->string('ketua_pdf')->nullable();
            $table->string('anggota1')->nullable();
            $table->string('anggota1_pdf')->nullable();
            $table->string('anggota2')->nullable();
            $table->string('anggota2_pdf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katsinov_beritas', function (Blueprint $table) {
            //
        });
    }
};
