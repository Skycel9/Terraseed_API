<?php

namespace App\Policies;

use App\Exceptions\AuthorizationException;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TagPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tag $tag): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool|AuthorizationException
    {
        return $user->hasPermission("CREATE_TAG") ?
            true :
            new AuthorizationException("You don't have permission to create tags");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tag $tag): bool|AuthorizationException
    {
        return $user->hasPermission("UPDATE_TAG") || $user->id === $tag->author->id ?
            true :
            new AuthorizationException("You don't have permission to update this tag");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag): bool|AuthorizationException
    {
        return $user->hasPermission("DELETE_TAG") ?
            true :
            new AuthorizationException("You don't have permission to delete this tag");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tag $tag): bool
    {
        return false;
    }
}
