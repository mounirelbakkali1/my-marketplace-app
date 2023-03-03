<?php

use App\Http\Controllers\HomeController;
use App\Services\ItemServiceImp;
use Illuminate\Support\Facades\Route;







// TODO :  Using The service container
Route::get('/', function () {
    return view("welcome");
});


