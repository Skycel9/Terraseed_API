<?php

use App\Http\Controllers\LikeController;
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

Route::get("test", function (Request $request) {
    $user = User::Find(1)->load("roles.permissions");
    return (new \App\Http\Resources\PermissionCollection($user->allPermissions()))->success()->setCode(200);


    /*$topic = new TopicResource(Topic::find());
    $topicRoles = $topic->roles()->with("permissions")->get();
    return \App\Http\Resources\RoleResource::collection($topicRoles);*/
});

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

Route::middleware('auth:sanctum')->group(function () {
    // Manage like endpoint
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
    Route::get('user-posts', [UserController::class, 'userPosts']);
    Route::delete('delete-account', [UserController::class, 'deleteAccount']);
    Route::get("me", [UserController::class, 'me'])->name("me");
    Route::get("profile/{id}", [UserController::class, "getProfile"]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
