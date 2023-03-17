<?php

namespace App\Policies;

use App\Models\Plante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlantePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('read plantes');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Plante $plante): bool
    {
        return $user->hasPermissionTo('read plantes');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create plantes');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Plante $plante): bool
    {
        return $user->hasPermissionTo('update plantes') && $user->id === $plante->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Plante $plante): bool
    {
        return $user->hasPermissionTo('delete plantes') && $user->id === $plante->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Plante $plante): bool
    {
        return $user->hasPermissionTo('restore plantes') && $user->id === $plante->user_id;
    }
}
