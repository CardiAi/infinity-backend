<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;

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

    public function login(LoginRequest $request){
        $validated = $request->validated();
        $user = User::where('email',$validated['email'])->first();
        if(!$user || ! Hash::check($validated['password'], $user->password)){
            return ApiResponseClass::throw('Wrong Credentials!', 401);
        }
        $token = $user->createToken("API TOKEN FOR " . $user->name);
        $result = [
            'user' => new UserResource($user),
            'token' => $token->plainTextToken
        ];
        return ApiResponseClass::sendResponse($result,'User Logged In Successfully!');
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return ApiResponseClass::sendResponse('Logged Out','User Logged Out Successfully!');
    }
}
