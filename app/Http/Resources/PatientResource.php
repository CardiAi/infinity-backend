<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'age' => $this->age,
            'last_record_date' => $this->last_record_date,
            'last_result' => $this->last_result,
            'created_at' => $this->created_at? $this->created_at->format('Y-m-d'): null
        ];
    }
}
