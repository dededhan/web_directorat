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
        Schema::table('comdev_submissions', function (Blueprint $table) {
            $table->dropColumn('sdgs');
            $table->json('sdgs_fokus')->nullable()->after('kata_kunci');
            $table->json('sdgs_pendukung')->nullable()->after('sdgs_fokus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comdev_submissions', function (Blueprint $table) {
            $table->dropColumn(['sdgs_fokus', 'sdgs_pendukung']);
            $table->json('sdgs')->nullable()->after('kata_kunci');
        });
    }
};
