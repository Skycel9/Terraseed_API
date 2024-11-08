<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index($id = null) {
        if ($id) {
            $video = Post::findOrFail($id);
            return new PostResource($video);
        }
        $video = Post::where("post_type", "post")->get();
        return new PostCollection($video);
    }
}
