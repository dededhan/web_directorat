<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_challenge_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('inov_challenge_submissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('member_type', ['internal', 'external']); // internal=dosen, external=alumni
            $table->string('role', 100)->default('Member'); // Leader, Member, Advisor, etc
            $table->enum('invitation_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_challenge_team_members');
    }
};
