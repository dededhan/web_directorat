<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inov_chalenge_tahap_fields', function (Blueprint $table) {
            $table->unsignedBigInteger('inov_chalenge_tahap_section_id')
                ->nullable()
                ->after('inov_chalenge_tahap_id');

            $table->foreign('inov_chalenge_tahap_section_id', 'tahap_fields_section_fk')
                ->references('id')
                ->on('inov_chalenge_tahap_sections')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inov_chalenge_tahap_fields', function (Blueprint $table) {
            $table->dropForeign('tahap_fields_section_fk');
            $table->dropColumn('inov_chalenge_tahap_section_id');
        });
    }
};
