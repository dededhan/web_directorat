<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('international_students', function (Blueprint $table) {
          
            $table->dropUnique('international_students_nim_unique');
            
            // Ubah kolom menjadi nullable
            $table->string('nim')->nullable()->change();
            $table->string('fakultas')->nullable()->change();
            $table->string('program_studi')->nullable()->change();

            $table->unique('nim', 'international_students_nim_unique');
        });
    }

    public function down()
    {
        Schema::table('international_students', function (Blueprint $table) {
            $table->dropUnique('international_students_nim_unique');
            
            $table->string('nim')->nullable(false)->change();
            $table->string('fakultas')->nullable(false)->change();
            $table->string('program_studi')->nullable(false)->change();
            
            $table->unique('nim', 'international_students_nim_unique');
        });
    }
};