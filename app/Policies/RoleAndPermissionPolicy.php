<?php

namespace App\Policies;

use App\Models\User;

class RoleAndPermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasDirectPermission('read users') ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('read users') ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasDirectPermission('update users') && $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteroles(User $user, User $model): bool
    {
        return $user->hasPermissionTo('delete roles');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasDirectPermission('restore users') && $user->id === $model->id;
    }
}
