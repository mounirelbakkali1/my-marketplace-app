<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemsControl;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\StatisticsController;
use App\Http\Requests\RegisterRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            $user =  User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('client');
            $user->save();
            return $user;
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

Route::get('items/uis', function (){
    return redirect()->route('itembyuis');
});


Route::group(['prefix' => 'v1'], function () {
     // Items
    Route::post('items', [ItemController::class, 'store'])->middleware(['sellerOnly']);
    Route::get('items', [ItemController::class, 'index']);
    Route::put('items/{item}', [ItemController::class, 'update'])->middleware(['sellerOnly']);
    Route::get('items/{item}', [ItemController::class, 'show']);
    Route::delete('items/{item}', [ItemController::class, 'destroy']);
    Route::get('items/{item}/details', [ItemController::class, 'getDetails']);
    Route::post('items/{item}/details', [ItemController::class, 'storeDetails'])->middleware(['sellerOnly']);
    Route::put('items/{item}/details', [ItemController::class, 'updateDetails'])->middleware(['sellerOnly']);
    Route::post('items/{item}/rate', [ItemController::class, 'rateItem']);
    Route::get('filter/items', [ItemController::class, 'queryItems']);

    // UIS
    Route::get('items/{item}/uis', [ItemController::class, 'getUIS']);
    Route::get('items/uis/encode', [ItemController::class, 'getItemByUIS'])->name('itembyuis');



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
    Route::put('sellers/{seller}', [SellerController::class, 'updateSeller']);


    // Roles & Permissions
    Route::apiResource('admin/roles', RoleController::class);
    Route::apiResource('admin/permissions', PermissionController::class);
    Route::get('admin/employees/{employee}/permissions', [PermissionController::class, 'getEmployeePermissions']);
    Route::post('admin/employees/{employee}/permissions', [PermissionController::class, 'assignEmployeePermissions']);
    Route::put('admin/employees/{employee}/permissions', [PermissionController::class, 'assignEmployeePermissions']);


    // History
    Route::get('seller/{seller}/history', [HistoryController::class, 'getSellerActivities'])->middleware(['sellerOnly']);
    Route::get('admin/history', [HistoryController::class, 'getSellersLogs']);


    // Complaints
    Route::apiResource('admin/complaints', ComplaintController::class)->only(['index', 'show'])->middleware(['auth:api','employeeOnly']);
    Route::post('admin/complaints/{complaint}/escalate', [ComplaintController::class, 'escalateComplaint'])->middleware(['auth:api','employeeOnly']);
    Route::post('admin/complaints/{complaint}/reject', [ComplaintController::class, 'closeComplaint'])->middleware(['auth:api','employeeOnly']);
    Route::post('customer/complaints', [ComplaintController::class, 'store'])->middleware('auth:api');


    // Contact
    Route::post('contact', [ContactController::class, 'store']);


    // management
    Route::apiResource('management/items', ItemsControl::class)->only(['index', 'show']);
    Route::post('management/items/{item}/suspend', [ItemsControl::class, 'suspendItem']);
    Route::post('management/items/{item}/unsuspend', [ItemsControl::class, 'unsuspendItem']);
    Route::post('management/sellers/{seller}/suspend', [AuthController::class, 'suspendAccount'])->middleware('employeeOnly');
    Route::post('management/sellers/{seller}/unblock', [AuthController::class, 'activateAccount'])->middleware('employeeOnly');


    // orders
    Route::apiResource('/customer/orders',OrderItemController::class)->only('store','show');
    Route::get('/customer/{user}/orders',[OrderItemController::class,'findCustomerOrders']);

    Route::get('/sellers/{seller}/commandes',[OrderController::class,'index'])->middleware(['sellerOnly']);
    Route::post('/sellers/commandes/{order}/confirm',[OrderController::class,'confirmOrder'])->middleware(['sellerOnly']);
    Route::post('/sellers/commandes/{order}/cancel',[OrderController::class,'cancelOrder'])->middleware(['sellerOnly']);
    Route::post('/sellers/commandes/{order}/deliver',[OrderController::class,'deliverOrder'])->middleware(['sellerOnly']);


    // Statistics
    Route::get('/seller/statistics',[StatisticsController::class,'getStatisticsForSeller'])->middleware(['auth:api','sellerOnly']);
    Route::get('/admin/statistics',[StatisticsController::class,'getStatisticsForAdmin'])->middleware(['auth:api','adminOnly']);
});



Route::group(['prefix'=>'test','middleware'=>['fromCookie','auth:api']], function () {
    Route::get('ping', function () {
        return 'pong-2';
    });
});
