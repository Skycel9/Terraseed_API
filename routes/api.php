<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;

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

Route::apiResource("posts", PostController::class)->withTrashed();

Route::apiResource("topics", TopicController::class)->withTrashed();

Route::get('topics/{id}/posts', [PostController::class, 'getPostsByTopic']);

Route::apiResource("posts.comments", CommentController::class)->except(["update"])->withTrashed()->shallow();

Route::apiResource("attachments", AttachmentController::class)->withTrashed();


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
