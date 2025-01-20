<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// import Models
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;

// import policies
use App\Policies\AttachmentPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\TopicPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Attachment::class => AttachmentPolicy::class,
        Comment::class => CommentPolicy::class,
        Post::class => PostPolicy::class,
        Topic::class => TopicPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
