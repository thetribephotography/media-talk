<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password
            ]);

            $token= $user->createToken($request->email)->plainTextToken;
            $user->api_token  = $token;
            $user->save();
            
        }
    }
}
