<?php

namespace App\Policies;

use App\Exceptions\AuthorizationException;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TopicPolicy
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
    public function view(User $user, Topic $topic): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission("CREATE_TOPIC") ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode(["unauthorized"=> "You're not allowed to create a new topic"]));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Topic $topic): bool
    {
        return $topic->author->id === $user->id || $user->hasPermission("UPDATE_TOPIC", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You cannot update this topic, because you're not the author or don't have this permission"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Topic $topic): bool
    {
        return $topic->author->id === $user->id || $user->hasPermission("DELETE_TOPIC", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You cannot delete this topic, because you're not the author or don't have this permission"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Topic $topic): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Topic $topic): bool
    {
        //
    }
}
