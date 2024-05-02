<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(PatientController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/patients', 'index');
    Route::post('/patient/add', 'store');
    Route::put('/patient/edit/{id}', 'update');
    Route::delete('/patient/delete/{id}', 'destroy');
});
