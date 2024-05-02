<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $fillable = ['chest_pain', 'blood_pressure', 'cholesterol', 'blood_sugar', 'ecg', 'max_thal', 'exercise_angina', 'old_peak', 'slope', 'coronary_artery', 'thal', 'result', 'patient_id'];
}
