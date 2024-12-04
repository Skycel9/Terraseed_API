<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\UserController;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$userPrefixes = [
    "me"=> null,
    "users/{id}"=> "id"
];

// Use custom auth class to allow authenticated or non-authenticated requests
// Required to auth users when token provide and don't ignore the token
//   -> Used by permissions based response output
Route::middleware("auth.optional")->group(function () {

    // Manage likes endpoints
    Route::get("posts/{id}/likes", [LikeController::class, "getLikes"])->name("posts.likes");
    Route::get("comments/{id}/likes", [LikeController::class, "getLikes"])->name("comments.likes");

    // Get nearest point from user location endpoint
    Route::get("posts/map", [PostController::class, "getPostsMap"])->name("posts.map");

    Route::apiResource("posts", PostController::class)->withTrashed()->only(["index", "show"]);
    Route::get('topics/{id}/posts', [TopicController::class, 'getPosts']);
    Route::get('tags/{id}/posts', [TagController::class, 'getPosts']);

    Route::apiResource("topics", TopicController::class)->withTrashed()->only(["index", "show"]);

    Route::apiResource("posts.comments", CommentController::class)->withTrashed()->only(["index", "show"])->shallow();

    Route::apiResource("attachments", AttachmentController::class)->withTrashed()->only(["index", "show"]);

    Route::apiResource("tags", TagController::class)->withTrashed()->only(["index", "show"]);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login'])->name("login");

Route::middleware('auth:sanctum')->group(function () use ($userPrefixes) {
    // Manage like endpoints
    Route::get("users/{id}/likes", [LikeController::class, "getUserLikes"])->name("users.like");
    Route::post("posts/{id}/like", [LikeController::class, "like"])->name("posts.like");
    Route::delete("posts/{id}/unlike", [LikeController::class, "unlike"])->name("posts.unlike");
    Route::post("comments/{id}/like", [LikeController::class, "like"])->name("comments.like");
    Route::delete("comments/{id}/unlike", [LikeController::class, "unlike"])->name("comments.unlike");

    // Allow posts edition to authenticated users
    Route::apiResource("posts", PostController::class)->withTrashed()->only(["update", "destroy"]);
    Route::post("topics/{id}/posts", [PostController::class, 'store']);

    // Add or delete comments only for authenticated users
    Route::apiResource("posts.comments", CommentController::class)->only(["store", "destroy"])->withTrashed()->shallow();

    // Allow topics edition to authenticated users
    Route::apiResource("topics", TopicController::class)->withTrashed()->only(["store", "update", "destroy"]);

    // Allow attachments edition to authenticated users
    Route::apiResource("attachments", AttachmentController::class)->withTrashed()->only(["update", "destroy"]);
    Route::post("topics/{topic_id}/posts/{post_id}/attachments", [AttachmentController::class, 'store']);

    // Allow tags edition to authenticated users
    Route::apiResource("tags", TagController::class)->withTrashed()->only(["store", "update", "destroy"]);

    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::delete('delete-account', [UserController::class, 'deleteAccount']);

    foreach ($userPrefixes as $prefix => $param) {
        Route::prefix($prefix)->group(function () use ($prefix, $param) {
            // Get account information
            Route::get("/", [UserController::class, 'getProfile'])->name("$prefix.profile");

            // Get content from user
            Route::get("posts", [UserController::class, 'getPosts'])->name("$prefix.posts");
            Route::get("comments", [UserController::class, 'getComments'])->name("$prefix.comments");
            Route::get("attachments", [UserController::class, 'getAttachments'])->name("$prefix.attachments");
            Route::get("topics", [UserController::class, 'getTopics'])->name("$prefix.topics");
            Route::get("tags", [UserController::class, 'getTags'])->name("$prefix.tags");
            Route::get("likes", [UserController::class, 'getLikes'])->name("$prefix.likes");

            // Get information about user relations
            Route::get("following", [RelationController::class, "getFollowing"])->name("$prefix.following");
            Route::get("followers", [RelationController::class, "getFollowers"])->name("$prefix.followers");
            Route::get("relations/blacklist", [RelationController::class, "getBlacklist"])->name("$prefix.blacklist");
            Route::get("relations/pending", [RelationController::class, "getPending"])->name("$prefix.relations.pending");
            Route::get("relations/requested", [RelationController::class, "getRequested"])->name("$prefix.relations.requested");

            // Get information about user subscriptions
            Route::get("subscriptions", [SubscriptionController::class, "index"])->name("$prefix.subscriptions");
        });

        Route::group(["prefix"=> "admin"], function() {
            Route::get("users", [UserController::class, "index"])->name("admin.users.index");

            Route::put("users/{id}", [UserController::class, "update"])->name("admin.users.update");
            Route::delete("users/{id}", [UserController::class, "delete"])->name("admin.users.delete");
        });
    }

    // Manage users relations endpoints
    Route::group(["prefix" => "users"], function () {
        // Manage user relation
        Route::post("follow/{id}", [RelationController::class, "follow"])->name("users.follow");
        Route::delete("unfollow/{id}", [RelationController::class, "unfollow"])->name("users.unfollow");

        Route::post("block/{id}", [RelationController::class, "block"])->name("users.block");
        Route::delete("unblock/{id}", [RelationController::class, "unblock"])->name("users.unblock");

        Route::post("accept/{id}", [RelationController::class, "accept"])->name("users.accept");
        Route::delete("reject/{id}", [RelationController::class, "reject"])->name("users.reject");

        Route::post("subscribe/{id}", [SubscriptionController::class, "subscribe"])->name("users.subscribe");
        Route::delete("unsubscribe/{id}", [SubscriptionController::class, "unsubscribe"])->name("users.unsubscribe");
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
