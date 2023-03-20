<?php

namespace App\Providers;

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
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        $rolesNames = ['client','seller','employee','admin'];
        $permissions=[
        'client'=>[
            'place order',
            'contact support',
        ],
        'seller'=>[
            'update profile',
            'read items',
            'read categories',
            'read collections',
            'create items',
            'update items',
            'delete items',
            'restore items'
        ],
        'employee'=>[
            'inactivate seller accounts',
            'report'
        ],
        'admin'=>[
            'read items',
            'read categories',
            'create plantes',
            'update collections',
            'delete items',
            'create categories',
            'update categories',
            'delete categories',
            'create collections',
            'update collections',
            'delete collections',
            'update profile',
            // important
            'read users',
            'delete users',
            'add roles',
            'delete roles',
            'update roles',
            'add permissions',
            'delete permissions',
            'update permissions',
            'create users',
            'update users',
            'read statistics',
        ]
    ];
        foreach ($rolesNames as $role){
            $role_created = Role::firstOrCreate(['name'=>$role,'guard_name' => 'api']);
            foreach ($permissions[$role] as $permissionName){
                $permission = Permission::firstOrCreate(['name'=>$permissionName,'guard_name' => 'api']);
                $role_created->givePermissionTo($permission);
            }
        }
    }
}
