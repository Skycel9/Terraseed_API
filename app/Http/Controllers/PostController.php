<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index($id = null) {
        $posts = Post::where("post_type", "post")->get();
        $collection = new PostCollection($posts);

        return (new BaseResource($collection))
            ->success()
            ->setCode(200)
            ->setMessage("Post list loaded successfully");
    }
    public function show($id) {
        $post = Post::findOrFail($id);
        $resource = new PostResource($post);

        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Post retrieved successfully");
    }

    public function store(Request $request) {
        var_dump($request->all());die;
        // TODO : Continue request
        $post = Post::create($request->all());
        $resource = new PostResource($post);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Post created successfully");
    }


}
