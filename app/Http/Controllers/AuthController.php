<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function response;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        // todo : creating token and login user
        $token = Auth::attempt($credentials);
        if(!$token){
            return response()->json([
                'status' => 'login failed',
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'status' => 'login success',
            'user'=> $user,
            'authorization' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ]
        ]);
    }


    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'register success',
            'user' => $user,
        ], 201);
    }
    public function logout(){
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'logout success'
        ]);
    }

    public function refresh(){
      return response()->json([
          'status' => 'success',
          'message' => 'refresh success',
          'user'=> Auth::user(),
          'authorization' => [
              'token' => Auth::refresh(),
              'token_type' => 'bearer',
          ]
      ]);
    }
}
