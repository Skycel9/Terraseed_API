<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidatorException;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PostCollection;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    function index() {
        $tags = Tag::all();
        $collection = new TagCollection($tags);

        return $collection
            ->success()
            ->setCode(200)
            ->setMessage("Tags list loaded successfully");
    }

    function show(int $id, Request $request) {
        $tag = Tag::find($id);

        if(!$tag) throw new NotFoundException("Not found", json_encode(["not_found" => "The tag you're trying to access was not found"]));

        $resource = new TagResource($tag);
        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Tag retrieve successfully");
    }

    function store(Request $request) {
        $this->authorize('create', Tag::class);

        $validator = Validator::make($request->all(), [
            "tag_name" => "required|string|max:25",
            "tag_description" => "nullable|string|max:255",
            "tag_color"=> "nullable|hex_color|max:255"
        ]);

        if ($validator->fails()) throw new ValidatorException("Data validation failed", json_encode($validator->errors()));

        $data = array(
            "tag_name"=> $request->get("tag_name"),
            "tag_slug"=> strToUrl($request->get("tag_name")),
            "tag_description"=> $request->get("tag_description"),
            "tag_color"=> $request->get("tag_color"),
            "tag_author"=> Auth::id()
        );

        $tag = Tag::create($data);
        $resource = new TagResource($tag);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Tag created successfully");
    }

    function update(Request $request, int $id) {
        $old_tag = Tag::find($id);
        $tag = Tag::find($id);
        if (!$old_tag || !$tag) throw new NotFoundException("Not found", json_encode(["not_found" => "The tag you're trying to update was not found"]));

        $this->authorize('update', [$old_tag]);

        $validator = Validator::make($request->all(), [
            "tag_name" => "nullable|string|max:25",
            "tag_description" => "nullable|string|max:255",
            "tag_color"=> "nullable|hex_color|max:255"
        ]);

        if ($validator->fails()) throw new ValidatorException("Data validation failed", json_encode($validator->errors()));

        $fieldsToUpdate = array(
            "tag_name"=> "tag_name",
            "tag_description"=> "tag_description",
            "tag_color"=> "tag_color"
        );

        $updated = false;

        foreach ($fieldsToUpdate as $field => $requestField) {
            if ($tag->{$field} != $request->get($requestField) && $request->get($requestField)) {
                $updated = true;
                $tag->{$field} = $request->get($requestField);

                // Generate a new slug only if title is update
                if ($field ==='tag_name') {
                    $tag->tag_slug = strToUrl($tag->tag_name);
                }
            }
        }

        if ($updated) {
            $tag->save();

            return (new PostCollection(["old"=> $old_tag, "new"=> $tag]))
                ->success()
                ->setCode(200)
                ->setMessage("Tag updated successfully");
        } else {
            return BaseResource::error()
                ->setCode(200)
                ->setMessage("Any changes made")
                ->setErrors(json_encode(["not_modified"=> "The tag is already up to date"]));
        }
    }

    function destroy(int $id) {
        $tag = Tag::find($id);
        if (!$tag) throw new NotFoundException("Not found", json_encode(["not_found" => "The tag you're trying to delete was not found"]));

        $this->authorize('delete', [$tag]);

        $tag->delete();

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Tag (" . $id . ") `" . $tag->tag_name . "` deleted successfully");
    }

    public function getPosts(int $id) {
        $tag = Tag::find($id);
        if (!$tag) throw new NotFoundException("Not found", json_encode(["not_found" => "The tag you're trying to access was not found"]));

        $posts = $tag->posts()->where("post_type", "post")->get();

        return (new PostCollection($posts))
            ->success()
            ->setCode(200)
            ->setMessage("Posts list by tag loaded successfully");
    }
}
