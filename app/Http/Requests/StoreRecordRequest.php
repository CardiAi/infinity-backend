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
            'blood_pressure' => 'nullable|numeric',
            'cholesterol' => 'nullable|integer',
            'blood_sugar' => 'required|integer',
            'ecg' => ['nullable', Rule::enum(ecgResult::class)],
            'max_thal' => 'required|numeric',
            'exercise_angina' => 'required|boolean',
            'old_peak' => 'required|numeric',
            'slope' => ['required', Rule::enum(slopeResult::class)],
            'coronary_artery' => 'required|numeric|in:0,1,2,3',
            'thal' => ['required', Rule::enum(thalType::class)],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'coronary_artery.in' => 'The selected coronary artery is invalid. Must be inside [0:3]',
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
