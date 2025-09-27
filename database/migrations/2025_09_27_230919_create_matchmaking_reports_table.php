<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchmaking_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matchmaking_submission_id')->constrained()->onDelete('cascade');
            $table->string('proposal_path')->nullable();
            $table->string('article_path')->nullable();
            $table->string('journal_q1_name')->nullable();
            $table->string('scimagojr_link')->nullable();
            $table->string('submit_proof_path')->nullable();
            $table->string('review_proof_path')->nullable();
            $table->string('travel_proof_path')->nullable();
            $table->integer('visit_days')->nullable();
            $table->json('qs_respondents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchmaking_reports');
    }
};
