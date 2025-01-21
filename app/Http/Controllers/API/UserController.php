<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\personal_access_token;
use Auth;

/**
 * @OA\Tag(
 *     name="User",
 *     description="Operations related to user authentication and account management"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     description="Registers a new user and returns an authentication token.",
     *     operationId="registerUser",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User registration data",
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "phone"},
     *             @OA\Property(property="name", type="string", description="Full name of the user", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", description="Email address", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", description="User's password", example="SecurePass123!"),
     *             @OA\Property(property="phone", type="string", description="User's phone number", example="+1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="accepted"),
     *             @OA\Property(property="token", type="string", example="1|aBcDeFgHiJkLmNoPqRsTuVwXyZ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict - User phone already exists",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="user phone already exists")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred while registering the user.")
     *         )
     *     )
     * )
     */
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
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login a user",
     *     description="Authenticates a user and returns an authentication token.",
     *     operationId="loginUser",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User login credentials",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", description="Email address", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", description="User's password", example="SecurePass123!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="massage", type="string", example="user logged in"),
     *             @OA\Property(property="token", type="string", example="2|zYxWvUtSrQpOnMlKjIhGfEdCbA")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="email or password do not match")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred during login.")
     *         )
     *     )
     * )
     */

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