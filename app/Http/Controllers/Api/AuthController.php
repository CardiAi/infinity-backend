<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){
        $validated = $request->validated();
        $user = User::create($request->safe()->only(['name','email','password']));
        if($user){
            $user->password = Hash::make($validated['password']);
            $user->save();
            return ApiResponseClass::sendResponse('Registered','User Registered Successfully!');
        }
        return ApiResponseClass::throw('Something Went Wrong!',500);
    }

    public function login(){
        return 'testing';
    }
}
