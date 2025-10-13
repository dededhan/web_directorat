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
        Schema::table('katsinov_beritas', function (Blueprint $table) {
            $table->text('penanggungjawab_signature')->nullable()->after('penanggungjawab_pdf');
            $table->text('ketua_signature')->nullable()->after('ketua_pdf');
            $table->text('anggota1_signature')->nullable()->after('anggota1_pdf');
            $table->text('anggota2_signature')->nullable()->after('anggota2_pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katsinov_beritas', function (Blueprint $table) {
            $table->dropColumn([
                'penanggungjawab_signature',
                'ketua_signature',
                'anggota1_signature',
                'anggota2_signature'
            ]);
        });
    }
};
