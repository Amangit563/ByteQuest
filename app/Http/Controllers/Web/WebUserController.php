<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebUserController extends Controller
{

    public function webLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error!!!',
                'error' => $validator->errors()
            ],422);
        }

        $credentials = $request->only('email', 'password');
    
        if(Auth::attempt($credentials)){
            return response()->json(['status' => 200]);
        }
    
        return back()->with('error', 'Invalid Credentials');
    }


    // *******************************  Logout  **********************

    public function webUserLogout(){
        Auth::logout();
        return redirect('/')->with('message', 'Logout Successfully');
    }
}
