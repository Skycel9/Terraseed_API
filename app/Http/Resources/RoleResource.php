<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends BaseResource
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
            "name"=> $this->role_name,
            "displayName"=> $this->role_display_name,
            "topic_id"=> $this->topic_id,
            "role_permissions"=> new PermissionCollection($this->whenLoaded("permissions"))
        );
    }
}
