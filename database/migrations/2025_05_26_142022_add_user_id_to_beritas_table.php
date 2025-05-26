<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Add the user_id column after the 'id' column
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // This will remove the foreign key constraint and the column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
