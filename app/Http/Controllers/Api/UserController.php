<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{

    // **********************  User Register  ************************

    public function userRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[A-Za-z\s]+$/'],
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'regex:/^[0-9]+$/'],
            'address' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $token = auth('api')->login($user);
        $token = $this->respondWithToken($token);


        return response()->json([
            'status' => 200,
            'message' => "User Register Successfully!!!",
            'data' => $user,
            'token' => $token
        ]);

        
    }

    // **********************  User Register  ************************



    // **********************  User Login  ************************



    // API Login
    public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }

    // **********************  User Login  ************************



    // **********************  User Logout  ************************

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
