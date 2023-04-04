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
    /*// firing PlaygroundEvent
    event(new PlaygroundEvent());
   $url = URL::temporarySignedRoute(
        'share-video', now()->addSeconds(30), ['video' => 123]
    );*/
    PlaygroundEvent::dispatch();

    return 'sent';
});


Route::get('/images/{name}', function ($name) {
    $path = storage_path('app/public/images/' . $name);
    if (!file_exists($path)) {
        abort(404);
    }
    $file = file_get_contents($path);
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $response = response($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});


