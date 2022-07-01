<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\User;
class UserController extends Controller
{
    public function login(Request $request){
        if (!Auth::attempt(['email' =>$request->email, 'password' =>$request->password])) {
            return response()->json([
                "success" =>false,
                "status" => 400,
            ]);
        }
        $user =auth()->user();
        // $token = $user->createToken("token");
        $token = $user->createToken('token')->accessToken;
        return $token->plainTextToken;



    }
}
