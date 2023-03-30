<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\LoginRequest;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use function array_merge;
use function cookie;
use function dd;
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
        $user = null;
        if (Auth::user()->role == Role::SELLER){
            $user = $this->getSellerInfo(Auth::user()->id);
        }
        $response = new Response($user);
        $response->withCookie(cookie('jwt', $token, 60, null, null, false, true)); // HttpOnly = true
        return $response;
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
        ],201);
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
        $this->authorize('view', [Auth::user(),User::class]);
        $user = User::with('roles.permissions')->findOrFail($user_id)->get();
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
    public function getSellerInfo($seller_id){
       // $this->authorize('view',[Auth::user(),User::class]);
        $seller = Seller::with(['AdditionalInfo.address'])->find($seller_id);
        return [
            'status' => 'success',
            'user'=>$seller
        ];
    }
}
