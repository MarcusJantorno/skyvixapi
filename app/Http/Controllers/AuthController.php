<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use App\Models\User as User;
use App\Custom\jwt as Jwt;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth(Request $request){
        $user = User::where('email', $request->email)->first();
        if(!$user){
            response()->json('not authorized', 401);
        }
        if($user && Hash::check($request->password, $user->password)){
            response()->json('not authorized', 401);
        }

        $token = Jwt::create($user);

        return response()->json([
            'token' => $token,
            'user' => [
                'name' => $user->name
            ]
            ]);
    }
}
