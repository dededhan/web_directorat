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
        $table->json('luaran_wajib')->nullable()->after('nominal_usulan');
        $table->json('luaran_opsional')->nullable()->after('luaran_wajib');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comdev_submissions', function (Blueprint $table) {
            //
        });
    }
};
