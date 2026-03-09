<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inov_chalenge_submission_members', function (Blueprint $table) {
            $table->enum('peran_ic', ['Hacker', 'Hustler', 'Hipster'])->nullable()->after('peran');
            $table->text('deskripsi_peran')->nullable()->after('peran_ic');
        });
    }

    public function down(): void
    {
        Schema::table('inov_chalenge_submission_members', function (Blueprint $table) {
            $table->dropColumn(['peran_ic', 'deskripsi_peran']);
        });
    }
};
