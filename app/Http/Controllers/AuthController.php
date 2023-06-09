<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateProfilInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
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
        ],[
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ]);
        $credentials = request(['email', 'password']);
        // todo : creating token and login user
        // create token
        $token = JWTAuth::attempt($credentials);
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
                'token_type' => 'bearer'
            ]
        ]);
    }


    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
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

    public function  userInfo($user_id){
        $this->authorize('read users', User::class);
        $user = User::with('roles.permissions')->findOrFail($user_id);
        $roles = $user->roles->pluck('name');
        $permissions = $user->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique();

        return response()->json([
            'status' => 'success',
            'message' => 'user info',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $roles,
                'permissions' => $permissions
            ],
        ], 200);
    }

    public function updateUserInfo(Request $request, $user_id){
        $this->authorize('update users', User::class);
        $user = User::findOrFail($user_id);
        $user->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'user info updated',
            'user' => $user
        ], 200);
    }

    public function deleteUser($user_id){
        $this->authorize('delete users', User::class);
        $user = User::findOrFail($user_id);
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'user deleted',
            'user' => $user
        ], 200);
    }

    public function updateProfile(UpdateProfilInfo $request, $user_id){
        $this->authorize('update profile', User::class);
        $user = User::findOrFail($user_id);
        $request=$request->validated();
        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'profil updated',
            'user' => $user
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request){
        $this->authorize('update profile', User::class);
        $user = User::findOrFail($request->user_id);
        $request->validated();
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'password updated',
            'user' => $user
        ], 200);
    }
}
