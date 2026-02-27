<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_session_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', [
                'draft',
                'diajukan',
                'menunggu_direview',
                'sedang_direview',
                'perbaikan_diperlukan',
                'proses_tahap_selanjutnya',
                'selesai',
            ])->default('draft');
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->timestamps();

            $table->foreign('inov_chalenge_session_id', 'sub_session_fk')
                ->references('id')->on('inov_chalenge_sessions')->cascadeOnDelete();
            $table->foreign('user_id', 'sub_user_fk')
                ->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('reviewer_id', 'sub_reviewer_fk')
                ->references('id')->on('users')->nullOnDelete();
            $table->unique(['inov_chalenge_session_id', 'user_id'], 'sub_session_user_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_submissions');
    }
};
