<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserManagerPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('read users');
    }

    public function view(User $user, User $model): bool
    {
        // methode to get all permissions of a user
        return $user->hasAllDirectPermissions('read users');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create users');
    }


    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('update users') || $user->id === $model->id;
    }


    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('delete users');
    }


}
