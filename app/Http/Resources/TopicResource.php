<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TopicResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=> $this->topic_title,
            "slug"=> $this->topic_slug,
            "banner"=> $this->whenLoaded("banner", fn ()=> new AttachmentResource($this->banner), $this->topic_banner),
            "icon"=> $this->whenLoaded("icon", fn ()=> new AttachmentResource($this->icon), $this->topic_icon),
            "author"=> $this->whenLoaded("author", fn ()=> new UserResource($this->author), $this->topic_author),
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
