<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class CommentResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $author = new UserResource(User::Find($this->post_author));
        $post = new PostResource(Post::Find($this->post_parent));

        return [
            "id"=> $this->id,
            "author"=> $author,
            "content"=> $this->post_content,
            "type"=> $this->post_type,
            "parent"=> $post
        ];
    }
}
