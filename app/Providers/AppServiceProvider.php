<?php

namespace App\Providers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Item;
use App\Observers\ItemObserver;
use App\Services\ItemService;
use App\Services\ItemServiceImp;
use App\Services\UISGenerator;
use App\Services\UISGeneratorImpl;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{


    public function register(): void
    {
        app()->bind(ItemService::class, ItemServiceImp::class);
        app()->bind(UISGenerator::class,UISGeneratorImpl::class);
        app()->bind(storeEmployeeRequest::class, StoreEmployeeRequest::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Item::observe(ItemObserver::class);

    }
}
