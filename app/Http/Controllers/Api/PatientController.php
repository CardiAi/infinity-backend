<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request){
        $patients = $request->user()->patients()->where(function ($query) use($request){
            if($request->has('search')){
                $query->filter(request(['search']));
            }
        })->paginate(10);
        if(!$patients->isNotEmpty()){
            return ApiResponseClass::sendResponse((object)[],'No data found');
        }
        return ApiResponseClass::sendResponse(PatientResource::collection($patients)->response()->getData(true),'');
    }

    public function show($id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        return ApiResponseClass::sendResponse(new PatientResource($patient),'Patient Retrieved Successfully');
    }

    public function store(StorePatientRequest $request){
        $validated = $request->validated();
        $patient = $request->user()->patients()->create($validated);
        if($patient){
            return ApiResponseClass::sendResponse(new PatientResource($patient),'Patient Added Successfully');
        }
        return ApiResponseClass::throw('Something Went Wrong!', 500);

    }

    public function update(UpdatePatientRequest $request, $id){
        $patient = Patient::find($id);
        if(!$patient){
            return ApiResponseClass::throw('Invalid ID', 404);
        }
        $validated = $request->validated();
        $patient->update($validated);
        return ApiResponseClass::sendResponse(new PatientResource($patient),'Patient Updated Successfully');

    }
    public function destroy($id){
        $patient = Patient::find($id);
        if($patient){
            $patient->delete();
            return ApiResponseClass::sendResponse('Deleted','Patient Deleted Successfully');
        }
        return ApiResponseClass::throw('Invalid ID', 404);
    }
}
