<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('katsinov_inovasis', function (Blueprint $table) {
            $table->text('tech_product')->change(); // Or MEDIUMTEXT
            $table->text('supremacy')->change();    // Or MEDIUMTEXT
            $table->text('patent')->change();       // Or MEDIUMTEXT
            $table->text('tech_preparation')->change(); // Or MEDIUMTEXT
            $table->text('market_preparation')->change(); // Or MEDIUMTEXT
        });
    }

    public function down(): void
    {
        Schema::table('katsinov_inovasis', function (Blueprint $table) {
            // Revert to previous types if known, e.g., VARCHAR(255)
            // Be cautious, this could truncate data if downgrading.
            $table->string('tech_product', 255)->change();
            $table->string('supremacy', 255)->change();
            $table->string('patent', 255)->change();
            $table->string('tech_preparation', 255)->change();
            $table->string('market_preparation', 255)->change();
        });
    }
};