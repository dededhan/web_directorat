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
            $table->text('tki')->nullable()->change();
            $table->text('opinion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katsinov_beritas', function (Blueprint $table) {
            $table->string('tki')->change();
            $table->string('opinion')->change();
        });
    }
};
