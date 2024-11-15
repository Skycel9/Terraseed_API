<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Validator;

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

    public function store($id, Request $request) {
        $validator = Validator::make($request->all(), [
            "comment_content"=> "required|string",
            "comment_author"=> "required|integer",
        ]);

        if ($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

        $data = array(
            "post_content"=> $request->get("comment_content"),
            "post_author"=> $request->get("comment_author"),
            "post_type"=> "comment",
            "post_parent"=> $id
        );

        $comment = Comment::create($data);
        $resource = new CommentResource($comment);

        return $resource
            ->success()
            ->setCode(201)
            ->setMessage("Comment created successfully");
    }

    public function show($id) {
        $comment = Comment::where("id", $id)
            ->where("post_type", "comment")
            ->firstOrFail();
        $resource = new CommentResource($comment);

        return $resource
            ->success()
            ->setCode(200)
            ->setMessage("Comment retrieved successfully");
    }

    public function destroy($id) {
        $comment = Comment::find($id);

        if (!$comment) return BaseResource::error()
            ->setCode(404)
            ->setMessage("Comment not found")
            ->setErrors(json_encode(["not_found"=> "The comment you're trying to delete does not exist"]));

        $comment->delete();

        $author = new UserResource(User::Find($comment->post_author));

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Comment (" . $id . ") `" . $this->truncateString($comment->post_content, 20) . "` posted by `" . $author->user_display_name . "` deleted successfully");
    }

    function truncateString(string $input, int $limit): string
    {
        // Vérifie si la chaîne est plus longue que la limite
        if (strlen($input) > $limit) {
            // Coupe la chaîne à la limite spécifiée et ajoute "..."
            return substr($input, 0, $limit) . '...';
        }

        // Retourne la chaîne si elle est déjà inférieure ou égale à la limite
        return $input;
    }
}
