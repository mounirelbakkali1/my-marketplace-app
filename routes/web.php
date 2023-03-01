<?php

use App\Http\Controllers\HomeController;
use App\Services\ItemServiceImp;
use Illuminate\Support\Facades\Route;


// TODO : resolving dependencies
Route::get('/index', function () {
    $serviceImp = app()->make(ItemServiceImp::class);
    //$serviceImp = app(ItemServiceImp::class);
    //$serviceImp = resolve(ItemServiceImp::class);
    return $serviceImp->showItem(1);
});




// TODO: Zero Configuration Resolution
Route::get('/home', function (ItemServiceImp $serviceImp) {
    return $serviceImp->showItem(1);
});





// TODO :  Using The service container
Route::get('/', function (HomeController $controller) {
    return $controller->index();
});


