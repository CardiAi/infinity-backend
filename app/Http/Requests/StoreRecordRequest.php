<?php

namespace App\Http\Requests;

use App\Enums\Enums\ChestPainType;
use App\Enums\Enums\ecgResult;
use App\Enums\Enums\slopeResult;
use App\Enums\Enums\thalType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $request->user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chest_pain' => ['required', Rule::enum(ChestPainType::class)],
            'blood_pressure' => 'required|numeric',
            'cholesterol' => 'required|numeric',
            'blood_sugar' => 'required|numeric',
            'ecg' => ['required', Rule::enum(ecgResult::class)],
            'max_thal' => 'required|numeric',
            'exercise_angina' => 'required|boolean',
            'old_peak' => 'required|numeric',
            'slope' => ['required', Rule::enum(slopeResult::class)],
            'coronary_artery' => 'required|numeric',
            'thal' => ['required', Rule::enum(thalType::class)],
        ];
    }
}
