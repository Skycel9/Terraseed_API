<?php

namespace App\Http\Controllers;

use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index($id = null) {
        $topics = Topic::all();
        $collection = new TopicCollection($topics);

        return $collection
            ->success()
            ->setCode(200)
            ->setMessage("Topic list loaded successfully");
    }
    public function show($id) {
        $topic = Topic::findOrFail($id);
        $resource = new TopicResource($topic);

        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Topic retrieved successfully");
    }
}
