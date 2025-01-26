<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loginUser(Request $request)
    {
        $input = $request->all();


        Auth::attempt($input);
        $user = auth()->user();
        $token = $user->createToken('authToken')->accessToken;
        return Response(['status'=> 200,'token' => $token], 200);

    }


    public function getUserDetail()
    {

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            return response()->json(['user' => $user], 200);
        }
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    public function userLogout(Request $request)
    { 
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $user->token()->revoke();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
