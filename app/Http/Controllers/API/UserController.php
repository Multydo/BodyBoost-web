<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\personal_access_token;
use Auth;

class UserController extends Controller
{
    public function register(Request $request){
        $user_data = $request->all();
        $user_phone = $user_data['phone'];
        $user_phone_exists = User::where('phone',$user_phone)->exists();
        if($user_phone_exists){
            return response()-> json([
                "message" => "user phone alredy exists"
            ],409);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        $token = $user->createToken($request['email'])->plainTextToken;
        return response()->json([
            "message"=>"accepted",
            "token"=>$token
        ],201);
    }

    public function login(Request $user_data){
        $credentials = $user_data->only('email', 'password');
        if(Auth::attempt($credentials)){
            $user_email = $user_data['email'];
            $user_info = User::where('email' , $user_email)->first();
            $user_username = $user_info ->username;
            $old_token = personal_access_token::where("name",$user_username);
            if($old_token){
                $old_token -> delete();
            }
            $user = Auth::user();
            $token = $user->createToken($user_username)->plainTextToken;
            $tokenStatus = personal_access_token::find( $token);
            $tokenStatus->last_used_at = Carbon::now();
            $tokenStatus->save();
            return response() -> json([
                "massage"=>"user loged in",
                "token" => $token
            ],200);
        }else{
            return response()->json([
                "message"=>"email or password do not match"
            ],401);
        }
    }

    
}