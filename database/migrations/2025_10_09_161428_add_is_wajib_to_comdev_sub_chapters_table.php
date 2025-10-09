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
        Schema::table('comdev_sub_chapters', function (Blueprint $table) {
            $table->boolean('is_wajib')->default(false)->after('urutan')->comment('Status wajib/tidak wajib untuk sub-bab ini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comdev_sub_chapters', function (Blueprint $table) {
            $table->dropColumn('is_wajib');
        });
    }
};
