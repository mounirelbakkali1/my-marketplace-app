<?php

use App\Events\PlaygroundEvent;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Services\ItemServiceImp;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;


// TODO :  Using The service container
Route::get('/', function () {
    return view("welcome");
});

Route::get('/playground',function () {
    // firing PlaygroundEvent
    event(new PlaygroundEvent());
   /* $url = URL::temporarySignedRoute(
        'share-video', now()->addSeconds(30), ['video' => 123]
    );*/

    return 'sent';
});



