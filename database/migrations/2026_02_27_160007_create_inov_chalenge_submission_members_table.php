<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_submission_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            // nullable: alumni/dosen have accounts; eksternal may not
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('peran', ['Ketua', 'Anggota']);
            $table->enum('tipe_anggota', ['dosen', 'alumni', 'eksternal']);
            $table->string('nama_lengkap');
            $table->string('nik_nim_nip')->nullable();
            $table->string('institusi_fakultas')->nullable();
            // alumni: starts as 'pending'; dosen/eksternal: 'not_required'
            $table->enum('approval_status', ['not_required', 'pending', 'approved', 'rejected'])
                ->default('not_required');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->foreign('inov_chalenge_submission_id', 'sm_submission_fk')
                ->references('id')->on('inov_chalenge_submissions')->cascadeOnDelete();
            $table->foreign('user_id', 'sm_user_fk')
                ->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_submission_members');
    }
};
