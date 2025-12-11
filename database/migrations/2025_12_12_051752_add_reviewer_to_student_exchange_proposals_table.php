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
        Schema::table('proposal_student_exchange', function (Blueprint $table) {
            $table->decimal('nilai_reviewer', 5, 2)->nullable()->after('komentar_reviewer');
            $table->timestamp('tanggal_review')->nullable()->after('nilai_reviewer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_student_exchange', function (Blueprint $table) {
            $table->dropColumn(['nilai_reviewer', 'tanggal_review']);
        });
    }
};
