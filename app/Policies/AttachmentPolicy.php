<?php

namespace App\Policies;

use App\Exceptions\AuthorizationException;
use App\Models\Attachment;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttachmentPolicy
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
    public function view(User $user, Attachment $attachment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Topic $topic, Post $post): bool
    {
        return $user->id === $post->post_author && $user->hasPermission("POST_ATTACHMENT", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You're not allowed to post attachments in this topic"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attachment $attachment): bool
    {
        $topic = getParentTopic($attachment);
        return $user->id === $attachment->post_author || $user->hasPermission("EDIT_ATTACHMENT", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You're not allowed to edit attachments in this topic"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attachment $attachment): bool
    {
        $topic = getParentTopic($attachment);
        return $user->id === $attachment->post_author || $user->hasPermission("DELETE_ATTACHMENT", $topic?->id) ?
            true :
            throw new AuthorizationException("Unauthorized action", json_encode("You're not allowed to delete this attachment"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attachment $attachment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attachment $attachment): bool
    {
        return false;
    }
}
