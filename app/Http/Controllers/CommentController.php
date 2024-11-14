<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function index() {
        $comments = Comment::where('post_type', "comment")->get();
        $collection = new CommentCollection($comments);

        return $collection
            ->success()
            ->setCode(200)
            ->setMessage("Comment list loaded successfully");
    }

    public function show(Request $request, $args) {
        var_dump($args);die;
        $comment = Comment::where("post_type", "comment")->findOrFail($id);
        $resource = new CommentResource($comment);

        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Comment retrieved successfully");
    }
}
