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
        Schema::table('apc_submissions', function (Blueprint $table) {
            $table->string('bukti_pembayaran_path')->nullable()->after('submission_process_path');
            $table->text('catatan_revisi')->nullable()->after('bukti_pembayaran_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apc_submissions', function (Blueprint $table) {
            //
        });
    }
};
