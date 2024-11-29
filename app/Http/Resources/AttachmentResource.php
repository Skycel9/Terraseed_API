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

        $this->resource->loadMissing(["metas"]);
        return [
            "id"=> $this->id,
            "author"=> $this->whenLoaded("author", fn ()=> new UserResource($this->author), $this->post_author),
            "title"=>$this->post_title,
            "type"=>$this->post_type,
            "slug"=> $this->post_slug,
            "parent"=> $this->whenLoaded("parent", fn ()=> new PostResource($this->parent), $this->post_parent),
            "meta"=> $this->whenLoaded("metas", fn ()=> new PostmetaCollection($this->resource->metas()->get()))
        ];

    }
}
