<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RecordController extends Controller
{
    public function index($id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        $records = $patient->records()->paginate(10);
        if(!$records->isNotEmpty()){
            return ApiResponseClass::sendResponse((object)[],'No data found');
        }
        return ApiResponseClass::sendResponse(RecordResource::collection($records)->response()->getData(true),'');
    }

    public function show($id){
        $record = Record::find($id);
        if(!$record){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        return ApiResponseClass::sendResponse(new RecordResource($record),'Record Retrieved Successfully');
    }

    public function store(StoreRecordRequest $request, $id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        $validated = $request->validated();
        //return $validated;
        $data = [
            'chest_pain' => $validated['chest_pain'],
            'blood_pressure' => $validated['blood_pressure']? (int)$validated['blood_pressure']: null,
            'cholesterol' => $validated['cholesterol']? (int)$validated['cholesterol']: null,
            'blood_sugar' => $validated['blood_sugar']>20? true: false,
            'ecg' => $validated['ecg']? $validated['ecg']: null,
            'max_thal' => (int)$validated['max_thal'],
            'exercise_angina' => $validated['exercise_angina'] == "0"? false: true,
            'old_peak' =>(float)$validated['old_peak'],
            'slope' => $validated['slope'],
            'coronary_artery' => (int)$validated['coronary_artery'],
            'thal' => $validated['thal'],
            'age' => $patient->age,
            'gender' => $patient->gender
        ];
        //return $data;
        //send validated data to model
        $response = Http::accept('application/json')->post('https://cardiai-model-c5006df9a332.herokuapp.com/predict',$data);
        if(isset($response['prediction'])){
            $result = $response['prediction'];
            if($result >= 0 && $result < 5){ //validate result
                $data['result'] = $result;
                $data['exercise_angina'] == true? $data['exercise_angina'] =1: $data['exercise_angina']=0;
                $record = DB::transaction(function () use ($data, $patient){
                    $record = $patient->records()->create($data);
                    $patient->last_record_date = now();
                    $patient->last_result = $data['result'];
                    $patient->save();
                    return $record;
                });
                return ApiResponseClass::sendResponse(new RecordResource($record->load('patient')),'Record Added Successfully');
            }
            return $response;
            return ApiResponseClass::throw('Something Went Wrong!', 500);
        }
        return $response;
        return ApiResponseClass::throw('Something Went Wrong!', 500);

    }
}
