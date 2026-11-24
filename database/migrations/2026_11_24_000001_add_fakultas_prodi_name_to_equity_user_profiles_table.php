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
            if (!Schema::hasColumn('equity_user_profiles', 'fakultas_name')) {
                $table->string('fakultas_name')->nullable()->after('fakultas_id');
            }
            if (!Schema::hasColumn('equity_user_profiles', 'prodi_name')) {
                $table->string('prodi_name')->nullable()->after('prodi_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equity_user_profiles', function (Blueprint $table) {
            $columns = array_filter(['fakultas_name', 'prodi_name'], fn ($col) => Schema::hasColumn('equity_user_profiles', $col));
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
