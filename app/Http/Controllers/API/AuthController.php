<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email"=> "required|email",
            "password"=> "required",
            "confirm_password" => "required|same:password",
        ]);

        if ($validator->fails()){
            return response()->json([
                "status" => "0",
                "message" => "Validation Failed",
                "error"=> $validator->errors()->all(),
            ]);
        }

        $user = User::create([
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> bcrypt($request->password) 
        ]);

        $token = $user->createToken("AdminApp")->accessToken;

        $response = [];
        $response["name"] = $user->name;
        $response["email"] = $user->email;
        $response["password"] = $user->password;
        $response["token"] = $token;

        return response()->json([
            "status"=> "1",
            "message"=> "User Registered",
            "data" => $response,
        ]);
    } 

    public function login(Request $request){
        if(Auth :: attempt(["email"=> $request->email,"password"=> $request->password]))
        {
            $user = Auth::user();

            $token = $user->createToken("AdminApp")->accessToken;

            $response = [];
            $response["name"] = $user->name;
            $response["email"] = $user->email;
            $response["password"] = $user->password;
            $response["token"] = $token;

            return response()->json([
                "status"=> "1",
                "message"=> "User Logged in",
                "data" => $response,
            ]);
        }
        return response()->json([
            "status" => "0",
            "message" => "User Unauthenticated",
            "data" => null,
        ]);
    }

    
}
