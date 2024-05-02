<?php

use App\Enums\Enums\ChestPainType;
use App\Enums\Enums\ecgResult;
use App\Enums\Enums\slopeResult;
use App\Enums\Enums\thalType;
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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->enum('chest_pain', [ChestPainType::TYPICAL_ANGINA->value, ChestPainType::ATYPICAL_ANGINA->value, ChestPainType::NON_ANGINAL->value, ChestPainType::ASYMPTOMATIC->value]);
            $table->integer('blood_pressure');
            $table->integer('cholesterol');
            $table->integer('blood_sugar');
            $table->enum('ecg',[ecgResult::NORMAL->value, ecgResult::STT_ABNORMALITY->value,
            ecgResult::LV_HYPERTROPHY->value]);
            $table->integer('max_thal');
            $table->boolean('exercise_angina');
            $table->decimal('old_peak');
            $table->enum('slope',[slopeResult::FLAT->value, slopeResult::DOWNSLOPING->value, slopeResult::UPSLOPING->value]);
            $table->integer('coronary_artery');
            $table->enum('thal',[thalType::NORMAL->value, thalType::FIXED_DEFECT->value, thalType::REVERSIBLE_DEFECT->value]);
            $table->integer('result');
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
