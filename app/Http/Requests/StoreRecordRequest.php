<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Enums\Enums\thalType;
use App\Enums\Enums\ecgResult;
use Illuminate\Validation\Rule;
use App\Enums\Enums\slopeResult;
use App\Enums\Enums\ChestPainType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'blood_pressure' => 'nullable|numeric|min:0|max:200',
            'cholesterol' => 'nullable|numeric|min:0|max:603',
            'blood_sugar' => 'required|numeric',
            'ecg' => ['nullable', Rule::enum(ecgResult::class)],
            'max_thal' => 'required|numeric|min:60|max:202',
            'exercise_angina' => 'required|boolean',
            'old_peak' => 'required|numeric|min:-2.6|max:6.2',
            'slope' => ['required', Rule::enum(slopeResult::class)],
            'coronary_artery' => 'required|integer|min:0|max:3',
            'thal' => ['required', Rule::enum(thalType::class)],
        ];
    }
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'errors'      => $validator->errors()
        ],400));
    }
}
