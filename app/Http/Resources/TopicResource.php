<?php

namespace App\Http\Resources;

use App\Models\User;
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
        $author = new UserResource(User::Find($this->topic_author));
        return [
            "id"=> $this->id,
            "title"=> $this->topic_title,
            "slug"=> $this->topic_slug,
            "banner"=> $this->topic_banner,
            "icon"=> $this->topic_icon,
            "author"=> $author,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
