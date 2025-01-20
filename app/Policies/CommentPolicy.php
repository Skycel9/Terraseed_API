<?php

namespace App\Policies;

use App\Exceptions\AuthorizationException;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Post $post): bool|AuthorizationException
    {
        $topic = $post->parent;
        return $user->hasPermission("POST_COMMENT", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You're not allowed to post a comment"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool|AuthorizationException
    {
        $topic = getParentTopic($comment);
        return $user->id === $comment->post_author || $user->hasPermission("DELETE_COMMENT", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You cannot delete this comment, because you're not the author or don't have this permission"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
