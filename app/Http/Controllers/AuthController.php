<?php

namespace App\Http\Controllers;

use App\Enums\AccountStatus;
use App\Enums\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Seller;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\MediaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use function response;

class AuthController extends Controller
{
    private MediaService $mediaService;
    protected UserPolicy $userPolicy;
    public function __construct(MediaService $mediaService, UserPolicy $userPolicy)
    {
        $this->userPolicy = $userPolicy;
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
        if($user->account_status != AccountStatus::ACTIVE){
            return response()->json([
                'status' => 'error',
                'message' => 'Your account is '.$user->account_status,
            ], 401);
        }
        if ($user->role == Role::SELLER){
            $user = $this->getSellerInfo($user->id);
        }
        $response =  response([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
/*        $response->withCookie(cookie('jwt', $token, 120, null, null, true, true, false, 'Non'));*/
        //$response->withCookie(cookie('jwt', $token, 120, '/', 'http://127.0.0.1:5173', false, true, false, 'None'));
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

    public static function registerSeller(mixed $validated)
    {
        $seller = User::create([
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
        $seller->assignRole('admin');
        $seller->save();
        $roles = $seller->roles->pluck('name');
        return $roles;
    }

    public function createEmployee(StoreEmployeeRequest $request)
    {
        //$this->authorize('create', [Auth::user(),User::class]);
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $user->assignRole($validated['role']);
       /* foreach ($validated['permissions'] as $permission){
            $user->givePermissionTo($permission);
        }*/
        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'user' => $user,
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
    public function getSellerInfo($seller_id){
       // $this->authorize('view',[Auth::user(),User::class]);
        $seller = Seller::with(['AdditionalInfo.address'])->find($seller_id);
        return [
            'status' => 'success',
            'user'=>$seller
        ];
    }

    public function getEmployees(){
        if (!Auth::user()->hasRole('admin')){
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to do this action',
            ], 401);
        }
        $employees = User::with('roles')->whereHas('roles',function ($query){
            $query->where('name','employee');
        })->get();
        return response()->json([
            'status' => 'success',
            'message' => 'employees list',
            'employees' => $employees,
        ], 200);
    }


    public function suspendAccount($user_id){
        $user = User::findOrFail($user_id);
        $user->account_status = AccountStatus::SUSPENDED;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Account suspended successfully',
        ], 200);
    }

    public function activateAccount($user_id){
        $user = User::findOrFail($user_id);
        $user->account_status = AccountStatus::ACTIVE;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Account activated successfully',
        ], 200);
    }



}
