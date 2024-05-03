<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chest_pain' => $this->chest_pain,
            'blood_pressure' => $this->blood_pressure,
            'cholesterol' => $this->cholesterol,
            'blood_sugar' => $this->blood_sugar,
            'max_thal' => $this->max_thal,
            'exercise_angina' => $this->exercise_angina,
            'old_peak' => $this->old_peak,
            'slope' => $this->slope,
            'coronary_artery' => $this->coronary_artery,
            'thal' => $this->thal,
            'result' => $this->result,
            'created_at' => $this->created_at
        ];
    }
}
