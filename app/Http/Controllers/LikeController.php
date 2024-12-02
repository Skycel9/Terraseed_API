<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizationException;
use App\Exceptions\NotFoundException;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserCollection;
use App\Models\Comment;
use App\Models\Content;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LikeController extends Controller
{
    public function getLikes(int $id) {
        $content = Content::find($id);

        if (!$content) throw new NotFoundException("Not found", json_encode(["not_found"=> "The post you're trying access doesn't exist"]));

        $likes = $content->likes;

        return (new UserCollection($likes))
            ->success()
            ->setCode(200)
            ->setMessage(ucfirst($content->post_type) . " likes retrieved successfully");
    }

    public function getUserLikes(int $id) {

        $id = $id ?? Auth::id();

        $user = User::find($id);
        if (!$user) throw new NotFoundException("Not found", json_encode(["not_found"=> "The user you are looking for does not exist"]));

        if (!Auth::user()->hasRole(1) && $user->id !== Auth::id()) throw new AuthorizationException("Unauthorized action", json_encode(["unauthorized" => "You are not authorized to access this resource"]));

        $likes = $user->likes;
        return (new PostCollection($likes))
            ->success()
            ->setCode(200)
            ->setMessage("User's likes retrieved successfully");
    }

    public function like(int $id) {
        $route = explode(".", Route::currentRouteName())[0];
        $content = $route === "posts" ? Post::find($id) : Comment::find($id);

        if (!$content) throw new NotFoundException("Not found", json_encode(["not_found"=> "The $route you're trying access doesn't exist"]));

        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $content->id
        ]);


        if (!$like->wasRecentlyCreated) return (new BaseResource([]))
            ->error()
            ->setCode(409)
            ->setMessage("You already liked this post");

        return (new PostResource($content))
            ->success()
            ->setCode(200)
            ->setMessage("You liked this post");
    }

    public function unlike(int $id) {
        $route = explode(".", Route::currentRouteName())[0];
        $content = $route === "posts" ? Post::find($id) : Comment::find($id);
        if (!$content) throw new NotFoundException("Not found", json_encode(["not_found"=> "The $route you're trying access doesn't exist"]));

        $like = Like::where("user_id", Auth::id())
            ->where("post_id", $content->id)
            ->first();

        if (!$like) return (new BaseResource([]))
            ->error()
            ->setCode(409)
            ->setMessage("You didn't like this post");

        $like->delete();

        return (new PostResource($content))
            ->success()
            ->setCode(200)
            ->setMessage("You unliked this post");
    }
}
