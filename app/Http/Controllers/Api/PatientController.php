<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request){
        $patients = $request->user()->patients()->paginate(10);
        if(!$patients->isNotEmpty()){
            return ApiResponseClass::sendResponse([],'No data found');
        }
        return ApiResponseClass::sendResponse(PatientResource::collection($patients)->response()->getData(true),'');
    }

    public function update(Request $request, $id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        
    }
    public function destroy(Request $request){}
}
