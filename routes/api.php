<?php

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RecordController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    Route::get('/user', function (Request $request) {
        return ApiResponseClass::sendResponse(new UserResource($request->user()),'User Authenticated');
    })->middleware('auth:sanctum');
});

Route::controller(PatientController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/patients', 'index');
    Route::post('/patient/add', 'store');
    Route::put('/patient/edit/{id}', 'update');
    Route::delete('/patient/delete/{id}', 'destroy');
});

Route::controller(RecordController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/patient/{id}/records', 'index');
    Route::post('/patient/{id}/record/add', 'store');
});

Route::get('test', function(){
    return "testing";
});
