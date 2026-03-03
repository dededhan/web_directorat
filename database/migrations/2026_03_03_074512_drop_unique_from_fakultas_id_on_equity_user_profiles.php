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
            // Must drop FK first because MySQL uses the unique index for it
            $table->dropForeign(['fakultas_id']);
            $table->dropUnique(['fakultas_id']);

            // Re-add FK without unique, with a normal index
            $table->foreign('fakultas_id')->references('id')->on('equity_fakultas')->onDelete('cascade');
            $table->index('fakultas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equity_user_profiles', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
            $table->dropIndex(['fakultas_id']);

            $table->unique('fakultas_id');
            $table->foreign('fakultas_id')->references('id')->on('equity_fakultas')->onDelete('cascade');
        });
    }
};
