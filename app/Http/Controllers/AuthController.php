<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use function response;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['/','login','register']]);
    }
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $token = JWTAuth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or password is wrong',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public static function register($call)
    {
        $user = $call();
        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
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
}
