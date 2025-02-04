<?php

use App\Enums\QsGeneralRespondensType;
use App\Enums\YesNoQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quesioner_generals', function (Blueprint $table) {
            $table->id();
            $table->enum('respondent_type', array_column(QsGeneralRespondensType::cases(), 'value'));
            $table->string('firstname');
            $table->string('lastname');
            $table->string('institution');
            $table->string('activity_name');
            $table->date('activity_date');
            $table->string('country');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('survey_2023', array_column(YesNoQuestion::cases(), 'value'));
            $table->enum('survey_2024', array_column(YesNoQuestion::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quesioner_generals');
    }
};
