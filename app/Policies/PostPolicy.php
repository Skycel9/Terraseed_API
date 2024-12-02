<?php

namespace App\Policies;

use App\Http\Resources\BaseResource;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Exceptions\AuthorizationException;

class PostPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Topic $topic): bool | AuthorizationException {
        return $user->hasPermission("CREATE_POST", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You're not allowed to create a new post"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool | AuthorizationException {
        $topic = $post->topic;

        return $post->author->id === $user->id || $user->hasPermission("UPDATE_POST", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You cannot update this post, because you're not the author or don't have this permission"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool | AuthorizationException {
        $topic = $post->topic;

        return $post->author->id === $user->id || $user->hasPermission("DELETE_POST", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You cannot delete this post, because you're not the author or don't have this permission"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
