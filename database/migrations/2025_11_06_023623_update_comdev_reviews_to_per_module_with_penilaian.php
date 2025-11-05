<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('comdev_reviews')->truncate();
        
        Schema::table('comdev_reviews', function (Blueprint $table) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'comdev_reviews' 
                AND COLUMN_NAME = 'comdev_sub_chapter_id' 
                AND CONSTRAINT_NAME != 'PRIMARY'"
            );
            
            foreach ($foreignKeys as $key) {
                $table->dropForeign($key->CONSTRAINT_NAME);
            }
            
            if (Schema::hasColumn('comdev_reviews', 'comdev_sub_chapter_id')) {
                $table->dropColumn('comdev_sub_chapter_id');
            }
            
            if (!Schema::hasColumn('comdev_reviews', 'comdev_module_id')) {
                $table->foreignId('comdev_module_id')->after('comdev_submission_id')->constrained('comdev_modules')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('comdev_reviews', 'penilaian')) {
                $table->text('penilaian')->nullable()->after('komentar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comdev_reviews', function (Blueprint $table) {
            $table->dropForeign(['comdev_module_id']);
            $table->dropColumn(['comdev_module_id', 'penilaian']);
            
            $table->foreignId('comdev_sub_chapter_id')->after('comdev_submission_id')->constrained('comdev_sub_chapters')->onDelete('cascade');
        });
    }
};
