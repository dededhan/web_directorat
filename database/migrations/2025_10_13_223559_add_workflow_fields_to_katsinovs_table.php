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
        Schema::table('katsinovs', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'assigned', 'under_review', 'completed'])->default('completed')->after('moreuser_id');
            $table->foreignId('reviewer_id')->nullable()->after('status')->constrained('users')->onDelete('set null');
            $table->timestamp('submitted_at')->nullable()->after('reviewer_id');
            $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            $table->text('reviewer_notes')->nullable()->after('reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katsinovs', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn(['status', 'reviewer_id', 'submitted_at', 'reviewed_at', 'reviewer_notes']);
        });
    }
};
