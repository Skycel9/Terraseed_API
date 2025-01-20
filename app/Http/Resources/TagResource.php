<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array(
            "id"=> $this->id,
            "name"=> $this->tag_name,
            "slug"=> $this->tag_slug,
            "description"=> $this->tag_description,
            "color"=> $this->tag_color,
            "author"=> $this->whenLoaded("author", fn ()=> new UserResource($this->author), $this->tag_author)
        );
    }
}
