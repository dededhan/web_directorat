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
        // Add katsinov_id to form_record_hasil_pengukurans if not exists
        if (!Schema::hasColumn('form_record_hasil_pengukurans', 'katsinov_id')) {
            Schema::table('form_record_hasil_pengukurans', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained('katsinovs')->onDelete('cascade');
            });
        }
        
        // Add katsinov_id to berita_acara if not exists
        if (!Schema::hasColumn('berita_acara', 'katsinov_id')) {
            Schema::table('berita_acara', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained('katsinovs')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('form_record_hasil_pengukurans', 'katsinov_id')) {
            Schema::table('form_record_hasil_pengukurans', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
        
        if (Schema::hasColumn('berita_acara', 'katsinov_id')) {
            Schema::table('berita_acara', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
    }
};
