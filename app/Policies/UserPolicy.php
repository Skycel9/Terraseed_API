<?php

namespace App\Policies;

use App\Exceptions\AuthorizationException;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission("MANAGE_USERS") ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode(["unauthorized"=> "You're not allowed to view all users"]));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
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
        return $user->hasPermission("MANAGE_USERS") || $user->id === $model->id ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode(["unauthorized"=> "You're not allowed to update this user"]));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermission("MANAGE_USERS") || $user->id === $model->id ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode(["unauthorized"=> "You're not allowed to delete this user"]));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasPermission("MANAGE_USERS") ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode(["unauthorized"=> "You're not allowed to restore users"]));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
