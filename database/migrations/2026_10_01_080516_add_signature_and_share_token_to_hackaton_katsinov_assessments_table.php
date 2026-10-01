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
        Schema::table('hackaton_katsinov_assessments', function (Blueprint $table) {
            $table->longText('signature_image')->nullable()->after('notes');
            $table->timestamp('signed_at')->nullable()->after('signature_image');
            $table->string('share_token', 64)->nullable()->unique()->after('signed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hackaton_katsinov_assessments', function (Blueprint $table) {
            $table->dropColumn(['signature_image', 'signed_at', 'share_token']);
        });
    }
};
