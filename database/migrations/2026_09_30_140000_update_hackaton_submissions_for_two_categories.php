<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add kategori column if not exists
        if (!Schema::hasColumn('hackaton_submissions', 'kategori')) {
            Schema::table('hackaton_submissions', function (Blueprint $table) {
                $table->enum('kategori', ['d-farm', 'd-tech'])->nullable()->after('tema');
            });
        }

        // 2. Backfill kategori for existing rows based on tema
        DB::statement("UPDATE hackaton_submissions SET kategori = IF(tema LIKE '%D-FARM%', 'd-farm', 'd-tech') WHERE kategori IS NULL");

        // 3. Add explicit index on hackaton_session_id so foreign key requirement is satisfied
        Schema::table('hackaton_submissions', function (Blueprint $table) {
            $table->index('hackaton_session_id', 'hackaton_submissions_session_idx');
        });

        // 4. Create new unique index allowing 1 per (session, user, kategori)
        Schema::table('hackaton_submissions', function (Blueprint $table) {
            $table->unique(['hackaton_session_id', 'user_id', 'kategori'], 'hackaton_sub_session_user_kategori_unique');
        });

        // 5. Drop old unique constraint
        Schema::table('hackaton_submissions', function (Blueprint $table) {
            $table->dropUnique('hackaton_sub_session_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hackaton_submissions', function (Blueprint $table) {
            $table->unique(['hackaton_session_id', 'user_id'], 'hackaton_sub_session_user_unique');
            $table->dropUnique('hackaton_sub_session_user_kategori_unique');
            $table->dropIndex('hackaton_submissions_session_idx');
            $table->dropColumn('kategori');
        });
    }
};
