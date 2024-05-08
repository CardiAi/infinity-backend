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
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){
        info("User is trying to sign up");
        $validated = $request->validated();
        $user = User::create($request->safe()->only(['name','email','password']));
        if($user){
            $user->password = Hash::make($validated['password']);
            $user->save();
            info("User is created");
            return ApiResponseClass::sendResponse('Registered','User Registered Successfully!');
        }
        Log::error("Something Went Wrong");
        return ApiResponseClass::throw('Something Went Wrong!',500);
    }

    public function login(LoginRequest $request){
        info("User is trying to login");
        $validated = $request->validated();
        $user = User::where('email',$validated['email'])->first();
        info("Checking credentials");
        if(!$user || ! Hash::check($validated['password'], $user->password)){
            Log::error("Wrong Credentials");
            return ApiResponseClass::throw('Wrong Credentials!', 401);
        }
        $token = $user->createToken("API TOKEN FOR " . $user->name);
        info("Token generated");
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
