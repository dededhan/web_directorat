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
        DB::statement("ALTER TABLE `inov_chalenge_tahap_fields` MODIFY `field_type` ENUM('text','textarea','number','date','dropdown','checkbox','file','url') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `inov_chalenge_tahap_fields` MODIFY `field_type` ENUM('text','textarea','number','date','dropdown','file','url') NOT NULL");
    }
};
