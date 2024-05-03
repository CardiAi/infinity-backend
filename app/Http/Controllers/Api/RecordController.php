<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Resources\RecordResource;

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
        //
    }
}
