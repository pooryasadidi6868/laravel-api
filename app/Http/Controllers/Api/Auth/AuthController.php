<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user=User::create([
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> bcrypt($request->password)
        ]);
        $credentials = $request->only('email','password');
        if (!$token=Auth()->attempt($credentials)){
            abort(401);
        }


        return (new UserResource($user))->additional(
            [
                "meta" => [
                    "token" => $token
                ]
            ]
        ) ;
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email','password');
        if (!$token=Auth()->attempt($credentials)){
            return response()->json([
                "error" =>'this user not found'
            ],422);
        }


        return (new UserResource($request->user()))->additional(
            [
                "meta" => [
                    "token"=>$token
                ]
            ]
        ) ;
    }

    public function logout()
    {
        Auth()->logout();
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }
}
