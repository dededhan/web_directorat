<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->string('tahun', 10)->nullable()->after('sesi')->index();
        });
    }

    public function down(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->dropColumn('tahun');
        });
    }
};
