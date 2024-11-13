<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;

class PostResource extends BaseResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $author = new UserResource(User::Find($this->post_author));
        return [
            "id"=> $this->id,
            "title"=> $this->post_title,
            "slug"=> $this->post_slug,
            "description"=> $this->post_description,
            "content"=> $this->post_content,
            "coordinates"=> $this->when($this->post_coordinates != null, unserialize($this->post_coordinates)),
            "type"=> $this->post_type,
            "parent"=> $this->post_parent,
            "author"=> $author,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
