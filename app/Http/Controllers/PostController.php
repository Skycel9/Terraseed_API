<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Topic;
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

        $validator = Validator::make($request->all(), [
            "post_title"=> "required|string",
            "post_description"=> "required|string",
            "post_content"=> "required|string",
            "post_coordinates_lat"=> "decimal:1,10|nullable",
            "post_coordinates_long"=> "decimal:1,10|nullable",
            "post_author"=> "required|integer",
            "post_parent"=> "integer|nullable"
        ]);

        if($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

        $data = array(
            "post_title"=> $request->get("post_title"),
            "post_slug"=> strToUrl($request->get("post_title")),
            "post_description"=> $request->get("post_description"),
            "post_content"=> $request->get("post_content"),
            "post_coordinates"=> serialize(array("lat"=> $request->get("post_coordinates_lat"), "long"=> $request->get("post_coordinates_long"))),
            "post_type"=> "post",
            "post_author"=> $request->get("post_author"),
            "post_parent"=> $request->get("post_parent")
        );

        $post = Post::create($data);
        $resource = new PostResource($post);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Post created successfully");
    }

    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            "post_title"=> "string|nullable",
            "post_description"=> "string|nullable",
            "post_content"=> "string|nullable",
        ]);

        if ($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

        $post = Post::findOrFail($id);
        $old_post = Post::findOrFail($id);

        $fieldsToUpdate = [
            'post_title' => 'post_title',
            'post_description' => 'post_description',
            'post_content' => 'post_content'
        ];

        $updated = false;
        foreach ($fieldsToUpdate as $field => $requestField) {
            if ($post->{$field} != $request->get($requestField)) {
                $updated = true;
                $post->{$field} = $request->get($requestField);

                // Generate a new slug only if title is update
                if ($field === 'post_title') {
                    $post->post_slug = strToUrl($post->post_title);
                }
            }
        }

        if ($updated) {
            $post->save();

            return (new PostCollection(["old"=> $old_post, "new"=> $post]))
                ->success()
                ->setCode(200)
                ->setMessage("Post updated successfully");
        } else {
            return BaseResource::error()
                ->setCode(200)
                ->setMessage("Any changes made")
                ->setErrors(json_encode(["not_modified"=> "The post is already up to date"]));
        }
    }

    public function destroy($id) {

        $post = Post::find($id);

        if (!$post) return BaseResource::error()
            ->setCode(404)
            ->setMessage("Post not found")
            ->setErrors(json_encode(["not_found"=> "The post you're trying to delete does not exist"]));

        $post->delete();

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Post (" . $id . ") `" . $post->post_title . "` deleted successfully");
    }

    public function getPostsByTopic($id): PostCollection
    {
        $topic = Topic::findOrFail($id);

        $posts = $topic->posts()->where('post_type', 'post')->get();


        return (new PostCollection($posts))
            ->success()
            ->setCode(200)
            ->setMessage("Posts for this topic retrieved successfully");
    }
}
