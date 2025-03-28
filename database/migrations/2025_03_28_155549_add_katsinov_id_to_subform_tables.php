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
        // Check if innovator_forms table exists
        if (Schema::hasTable('innovator_forms') && !Schema::hasColumn('innovator_forms', 'katsinov_id')) {
            Schema::table('innovator_forms', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            });
        }
        
        // Add similar checks and modifications for other tables...
        // berita_acaras
        if (Schema::hasTable('berita_acaras') && !Schema::hasColumn('berita_acaras', 'katsinov_id')) {
            Schema::table('berita_acaras', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            });
        }
        
        // form_record_hasil_pengukurans
        if (Schema::hasTable('form_record_hasil_pengukurans') && !Schema::hasColumn('form_record_hasil_pengukurans', 'katsinov_id')) {
            Schema::table('form_record_hasil_pengukurans', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            });
        }
        
        // form_juduls (if it exists)
        if (Schema::hasTable('form_juduls') && !Schema::hasColumn('form_juduls', 'katsinov_id')) {
            Schema::table('form_juduls', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            });
        }
        
        // lampirans
        if (Schema::hasTable('lampirans') && !Schema::hasColumn('lampirans', 'katsinov_id')) {
            Schema::table('lampirans', function (Blueprint $table) {
                $table->foreignId('katsinov_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't drop any tables, just remove the foreign key constraints
        if (Schema::hasTable('innovator_forms') && Schema::hasColumn('innovator_forms', 'katsinov_id')) {
            Schema::table('innovator_forms', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
        
        // Similar for other tables
        if (Schema::hasTable('berita_acaras') && Schema::hasColumn('berita_acaras', 'katsinov_id')) {
            Schema::table('berita_acaras', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
        
        if (Schema::hasTable('form_record_hasil_pengukurans') && Schema::hasColumn('form_record_hasil_pengukurans', 'katsinov_id')) {
            Schema::table('form_record_hasil_pengukurans', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
        
        if (Schema::hasTable('form_juduls') && Schema::hasColumn('form_juduls', 'katsinov_id')) {
            Schema::table('form_juduls', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
        
        if (Schema::hasTable('lampirans') && Schema::hasColumn('lampirans', 'katsinov_id')) {
            Schema::table('lampirans', function (Blueprint $table) {
                $table->dropForeign(['katsinov_id']);
                $table->dropColumn('katsinov_id');
            });
        }
    }
};