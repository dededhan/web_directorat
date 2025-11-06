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
        Schema::table('comdev_modules', function (Blueprint $table) {
            $table->json('form_penilaian')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comdev_modules', function (Blueprint $table) {
            $table->dropColumn('form_penilaian');
        });
    }
};
