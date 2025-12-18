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
            $table->longText('validator_agreement_signature')->nullable()->after('status');
            $table->timestamp('validator_agreement_date')->nullable()->after('validator_agreement_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katsinovs', function (Blueprint $table) {
            $table->dropColumn(['validator_agreement_signature', 'validator_agreement_date']);
        });
    }
};
