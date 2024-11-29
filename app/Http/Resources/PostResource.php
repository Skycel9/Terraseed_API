<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostResource extends BaseResource
{
    public function __construct($resource, $from = null)
    {
        $this->from = $from;

        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $result = [
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
            "id" => $this->id,
            "title" => $this->post_title,
            "slug" => $this->post_slug,
            "description" => $this->when(!$this->fromComment, $this->post_description),
            "content" => $this->when(!$this->fromComment, $this->post_content),
            "coordinates" => $this->when($this->post_coordinates != null && !$this->fromComment, unserialize($this->post_coordinates)),
            "type" => $this->post_type,
            "author" => $this->whenLoaded("author", fn ()=> new UserResource($this->author), $this->post_author), // Don't create a request when author was not loaded
            "created_at" => $this->when(!$this->from === "comment", $this->created_at),
            "updated_at" => $this->when(!$this->from === "comment", $this->updated_at),
        ];

        return $this->applyExcludes($result);
    }
}
