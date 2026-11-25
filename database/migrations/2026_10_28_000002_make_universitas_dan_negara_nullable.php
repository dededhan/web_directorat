<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->string('negara')->nullable()->change();
            $table->string('universitas_asal')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('dosen_internasionals', function (Blueprint $table) {
            $table->string('negara')->nullable(false)->change();
            $table->string('universitas_asal')->nullable(false)->change();
        });
    }
};
