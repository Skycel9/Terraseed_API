<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function index($id = null) {
        $topics = Topic::with("author")->get();
        $collection = new TopicCollection($topics);

        return $collection
            ->success()
            ->setCode(200)
            ->setMessage("Topic list loaded successfully");
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        $resource = new TopicResource($topic);

        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Topic retrieved successfully");
    }

    public function store(Request $request) {
        $this->authorize("create", Topic::class);

        $validator = Validator::make($request->all(), [
            "topic_title"=> "required|string",
            "topic_slug"=> "required|string",
            "topic_author"=> "required|integer",
        ]);

        if($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

        $data = array(
            "topic_title"=> $request->get("topic_title"),
            "topic_slug"=> $request->get("topic_slug"),
            "topic_author"=> $request->get("topic_author"),
            "topic_banner"=> $request->get("topic_banner") ?: null,
            "topic_icon"=> $request->get("topic_icon") ?: null,
        );

        $topic = Topic::create($data);
        $resource = new TopicResource($topic);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Topic created successfully");
    }

    public function update(Request $request, $id) {
        $topic = Topic::find($id);
        $old_topic = Topic::find($id);

        if (!$topic || !$old_topic) throw new NotFoundException("Not found", json_encode(["not_found"=> "The topic you trying to edit does not exist"]));

        $this->authorize("update", $topic);

        $validator = Validator::make($request->all(), [
            "topic_title"=> "string|nullable",
            "topic_slug"=> "string|nullable",
            "topic_banner"=> "string|nullable",
            "topic_icon"=> "string|nullable",
        ]);

        if ($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

        $topic = Topic::findOrFail($id);
        $old_topic = Topic::findOrFail($id);

        $fieldsToUpdate = [
            'topic_title' => 'topic_title',
            'topic_slug' => 'topic_slug',
            'topic_banner' => 'topic_banner',
            'topic_icon' => 'topic_icon',
        ];

        $updated = false;
        foreach ($fieldsToUpdate as $field => $requestField) {
            if ($topic->{$field} != $request->get($requestField)) {
                $updated = true;
                $topic->{$field} = $request->get($requestField);

                // Generate a new slug only if title is update
                if ($field === 'topic_title' && $request->get($requestField)) {
                    $topic->topic_slug = strToUrl($topic->topic_title);
                }
            }
        }
        if ($topic->topic_slug == null) $topic->topic_slug = strToUrl($topic->topic_title);

        if ($updated) {
            $topic->save();

            return (new TopicCollection(["old"=> $old_topic, "new"=> $topic]))
                ->success()
                ->setCode(200)
                ->setMessage("Topic updated successfully");
        } else {
            return BaseResource::error()
                ->setCode(200)
                ->setMessage("Any changes made")
                ->setErrors(json_encode(["not_modified"=> "The topic is already up to date"]));
        }
    }

    public function destroy($id) {

        $topic = Topic::find($id);

        if (!$topic) throw new NotFoundException("Not found", json_encode(["not_found"=> "The topic you're trying to delete does not exist"]));

        $this->authorize("delete", [$topic]);

        $topic->delete();

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Topic (" . $id . ") `" . $topic->post_title . "` deleted successfully");
    }
}
