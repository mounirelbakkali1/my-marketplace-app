<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('read items');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Item $item): bool
    {
        return $user->hasPermissionTo('read items');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create items');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Item $item): bool
    {
        return $user->hasPermissionTo('update items') && $user->id === $item->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Item $item): bool
    {
        return $user->hasPermissionTo('delete items') && $user->id === $item->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Item $item): bool
    {
        return $user->hasPermissionTo('restore items') && $user->id === $item->user_id;
    }

    public function viewItems(Seller $seller): bool
    {
        return $seller->hasPermissionTo('read items');
    }

}
