<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inov_chalenge_reviews', function (Blueprint $table) {
            $table->unsignedSmallInteger('skor')->nullable()->after('penilaian')->comment('Score 0-100');
        });
    }

    public function down(): void
    {
        Schema::table('inov_chalenge_reviews', function (Blueprint $table) {
            $table->dropColumn('skor');
        });
    }
};
