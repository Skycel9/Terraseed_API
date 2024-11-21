<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\User;

class AttachmentResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        $author = new UserResource(User::FindOrFail($this->post_author));
        $metadata = new PostmetaCollection($this->resource->metas()->get());

        return [
            "id"=> $this->id,
            "author"=> $author,
            "title"=>$this->post_title,
            "type"=>$this->post_type,
            "slug"=> $this->post_slug,
            "parent"=> $this->post_parent,
            "meta"=> $metadata
        ];

    }
}
