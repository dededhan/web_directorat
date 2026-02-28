<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create the identitas table
        Schema::dropIfExists('inov_chalenge_submission_identitas');
        Schema::create('inov_chalenge_submission_identitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            $table->string('nama_produk');
            $table->string('skema_inovasi');
            $table->string('bidang_utama_produk');
            $table->timestamps();

            $table->unique('inov_chalenge_submission_id', 'ic_sub_identitas_uq');
            $table->foreign('inov_chalenge_submission_id', 'ic_sub_identitas_fk')
                ->references('id')
                ->on('inov_chalenge_submissions')
                ->cascadeOnDelete();
        });

        // 2. Deprecate has_anggota: set all existing tahap rows to false
        DB::table('inov_chalenge_tahap')->update(['has_anggota' => false]);
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_submission_identitas');
    }
};
