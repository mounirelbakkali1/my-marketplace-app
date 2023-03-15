<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SellerController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
     // Items
    Route::post('items', [ItemController::class, 'store']);
    Route::put('items/{item}', [ItemController::class, 'update']);
    Route::delete('items/{item}', [ItemController::class, 'destroy']);
    Route::get('items/{item}/details', [ItemController::class, 'getDetails']);
    Route::post('items/{item}/details', [ItemController::class, 'storeDetails']);
    Route::put('items/{item}/details', [ItemController::class, 'updateDetails']);

    // Categories
    Route::apiResource('categories', CategoryController::class);

    // Sellers
    Route::get('sellers', [SellerController::class, 'getSellers']);
    Route::get('sellers/{seller}', [SellerController::class, 'getSeller']);
    Route::get('sellers/{seller}/info', [SellerController::class, 'getSellerInfo']);

});
