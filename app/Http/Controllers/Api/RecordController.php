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

class RecordController extends Controller
{
    public function index($id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        $records = $patient->records()->paginate(10);
        if(!$records->isNotEmpty()){
            return ApiResponseClass::sendResponse([],'No data found');
        }
        return ApiResponseClass::sendResponse(RecordResource::collection($records)->response()->getData(true),'');
    }

    public function store(StoreRecordRequest $request, $id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        $validated = $request->validated();
        $validated['age'] = $patient->age;
        //send validated data to model
        $result = 2;
        if($result){ //validate result
            $validated['result'] = $result;
            $record = DB::transaction(function () use ($validated, $patient){
                $record = $patient->records()->create($validated);
                $patient->last_record_date = now();
                $patient->last_result = $validated['result'];
                $patient->save();
                return $record;
            });
            return ApiResponseClass::sendResponse(new RecordResource($record),'Record Added Successfully');
        }
        return ApiResponseClass::throw('Something Went Wrong!', 500);

    }
}
