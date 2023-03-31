<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\LoginRequest;
use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Seller;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use function array_merge;
use function dd;
use function response;

class AuthController extends Controller
{
    private MediaService $mediaService;
    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
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
        if ($user->role == Role::SELLER){
            $user = $this->getSellerInfo($user->id);
        }
        return response()->json(array_merge(
            [
                'message' => 'User logged in successfully',
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
                ],
               [
                     'user' => $user,
               ]
        )
        ,200);
        //return response($user, 201)->cookie('jwt', $token, 60, '/', null, true, true, false, 'None');
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

    public static function registerSeller(mixed $validated)
    {
        $seller = Seller::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $additionalInfo = new AdditionalProfilSettings();
        $additionalInfo->phone = $validated['phone'];
        $additionalInfo->websiteUrl = $validated['websiteUrl'];
        // TODO : add image using MediaService
        $address = new Address();
        $address->street = $validated['street'];
        $address->city = $validated['city'];
        $address->zip_code = $validated['zip_code'];
        $additionalInfo->address()->save($address);
        $additionalInfo->address_id = $address->id;
        $seller->AdditionalInfo()->save($additionalInfo);
        $seller->assignRole('seller');
        return $seller;
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
       // $this->authorize('view', [Auth::user(),User::class]);
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
