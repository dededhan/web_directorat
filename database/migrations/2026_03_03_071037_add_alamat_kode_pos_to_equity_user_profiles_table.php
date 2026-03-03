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
        Schema::table('equity_user_profiles', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('fakultas_id');
            $table->string('kode_pos', 10)->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equity_user_profiles', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'kode_pos']);
        });
    }
};
