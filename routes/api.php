<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Requests\RegisterRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', function (RegisterRequest $request) {
        return AuthController::register(function () use ($request){
            $validated = $request->validated();
            return Client::create($validated);
        });
    });
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('users/{user}', 'userInfo');
    Route::post('v1/admin/employees', 'createEmployee');
    Route::get('v1/admin/employees', 'getEmployees');
});



Route::post('ping', function () {
    $token = request()->cookie('jwt');
    return $token != null ? 'true' : 'false';
});

Route::group(['prefix' => 'v1'], function () {
     // Items
    Route::post('items', [ItemController::class, 'store']);
    Route::get('items', [ItemController::class, 'index']);
    Route::put('items/{item}', [ItemController::class, 'update']);
    Route::get('items/{item}', [ItemController::class, 'show']);
    Route::delete('items/{item}', [ItemController::class, 'destroy']);
    Route::get('items/{item}/details', [ItemController::class, 'getDetails']);
    Route::post('items/{item}/details', [ItemController::class, 'storeDetails']);
    Route::put('items/{item}/details', [ItemController::class, 'updateDetails']);
    Route::post('items/{item}/rate', [ItemController::class, 'rateItem']);
    Route::get('filter/items', [ItemController::class, 'queryItems']);

    // Categories
    Route::apiResource('categories', CategoryController::class);
    Route::get('categories/{category}/items', [CategoryController::class, 'getItemsByCategory']);

    // Collections
    Route::apiResource('collections', CollectionController::class)->except(['create']);
    Route::get('collections/{collection}/items', [CollectionController::class, 'getItemsByCollection']);

    // Sellers
    Route::get('sellers', [SellerController::class, 'index']);
    Route::get('sellers/{seller}', [SellerController::class, 'getSeller']);
    Route::get('sellers/{seller}/info', [SellerController::class, 'getSellerInfo']);
    Route::get('sellers/{seller}/items', [ItemController::class, 'getItemsBySeller']);
    Route::post('sellers', [SellerController::class, 'createSeller']);


    // Roles & Permissions
    Route::apiResource('admin/roles', RoleController::class);
    Route::apiResource('admin/permissions', PermissionController::class);
    Route::get('admin/employees/{employee}/permissions', [PermissionController::class, 'getEmployeePermissions']);
    Route::post('admin/employees/{employee}/permissions', [PermissionController::class, 'assignEmployeePermissions']);
    Route::put('admin/employees/{employee}/permissions', [PermissionController::class, 'assignEmployeePermissions']);


    // History
    Route::apiResource('admin/history', HistoryController::class)->only(['index', 'show']);


    // Complaints
    Route::apiResource('admin/complaints', ComplaintController::class)->only(['index', 'show', 'store', 'update', 'destroy']);


});
