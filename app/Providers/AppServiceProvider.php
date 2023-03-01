<?php

namespace App\Providers;

use App\Services\ItemService;
use App\Services\ItemServiceImp;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


    public function register(): void
    {
        app()->bind(ItemService::class, ItemServiceImp::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
