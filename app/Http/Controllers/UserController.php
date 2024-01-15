<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private function successMessage($msg, $data = [], $status_code = 200): JsonResponse
    {
        return response()->json([
            'status' => "success",
            'data' => $data,
            'message' => $msg
        ], $status_code);
    }

    private function errorMessage($msg, $data = [], $status_code = 400): JsonResponse
    {
        return response()->json([
            'status' => "error",
            'data' => $data,
            'message' => $msg
        ], $status_code);
    }

    public function register(RegisterRequest $request){
        try{
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token= $user->createToken($request->email)->plainTextToken;
            $user->api_token  = $token;
            $user->save();
        }catch(\Exception $err){
            return $this->errorMessage("Error Registering", $err->getMessage(), 400);
        }
    }


    public function login(Request $request){
        try{
            $request->validate([
                'email' => ['required'],
                'password' => ['required'],
            ]);

            $user = User::where('email', $request->email);

            if($user->exists()){
                $user = $user->first();
                if($user->password === $request->password){
                    return $this->successMessage("User Login Successful", $user, 200);
                } else{
                    return $this->errorMessage("User Password/Email Incorrect", [], 412);
                }
            }else{
                return $this->errorMessage("User does not Exist", [], 420);
            }


        }catch (\Exception $err){
            return $this->errorMessage("Error while Logining", $err->getMessage(), 400);
        }
    }
}
