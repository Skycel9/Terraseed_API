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
        return [
            "id" => $this->id,
            "author" => $this->whenLoaded("author", fn ()=> new UserResource($this->author), $this->post_author),
            "content" => $this->post_content,
            "type" => $this->post_type,
            "parent" => $this->whenLoaded("parent", fn ()=> new PostResource($this->parent, "comment"), $this->post_parent) // Allow different format of this resource when called from comment section
        ];
    }
}
