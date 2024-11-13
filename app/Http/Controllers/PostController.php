<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index($id = null) {
        $posts = Post::where("post_type", "post")->get();
        $collection = new PostCollection($posts);

        return $collection
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

        if ($request->header("x-post-type")) {
            $validator = Validator::make($request->all(), [
                "post_title"=> "required|string",
                "post_description"=> "required|string",
                "post_content"=> "required|string",
                "post_coordinates.lat"=> "decimal:1,10|nullable",
                "post_coordinates.long"=> "decimal:1,10|nullable",
                "post_author"=> "required|integer",
                "post_parent"=> "integer|nullable",
            ]);

            if($validator->fails()); {
                return (new BaseResource)->error();
            }

            $data = array(
                "post_title"=> $request->get("post_title"),
                "post_slug"=> $this->strToUrl($request->get("post_title")),
                "post_description"=> $request->get("post_description"),
                "post_content"=> $request->get("post_content"),
                "post_coordinates"=> serialize(array("lat"=> $request->get("post_coordinates.lat"), "long"=> $request->get("post_coordinates.long"))),
                "post_type"=> $request->header("x-post-type"),
            );
        }
        die;
        // TODO : Continue request
        $post = Post::create($request->all());
        $resource = new PostResource($post);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Post created successfully");
    }

    public function strToUrl(string $str): string {

        // Replace special chars with ASCII equivalent if exists
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

        // Replace quote by dash
        $str = preg_replace("/(\b\w)'(\b\w+[^\s])/", '$1-$2', $str);

        // Remove non-alphanumeric chars then replace spaces by dash
        $str = preg_replace('/[^a-zA-Z0-9\s-]/', '', $str);
        $str = preg_replace('/\s+/', '-', trim($str));

        return strtolower($str);
    }
}
