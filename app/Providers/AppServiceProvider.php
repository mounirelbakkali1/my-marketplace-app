<?php

namespace App\Providers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Item;
use App\Observers\ItemObserver;
use App\Services\ItemService;
use App\Services\ItemServiceImp;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{


    public function register(): void
    {
        app()->bind(ItemService::class, ItemServiceImp::class);
        app()->bind(storeEmployeeRequest::class, StoreEmployeeRequest::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Item::observe(ItemObserver::class);

    }
}
