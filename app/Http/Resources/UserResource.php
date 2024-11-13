<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "displayName"=> $this->user_display_name,
            "contact"=> [
                "email"=> $this->user_email,
                "phone"=> ["extension"=> $this->user_phone_ext, "number"=> $this->user_phone_number]
            ],
            "profile"=> [
                "firstName"=> $this->user_firstname,
                "lastName"=> $this->user_lastname,
                "gender"=> $this->user_gender,
                "birthday"=> $this->user_birthday
            ],
            "email_verified_at"=> $this->email_verified_at,
            "created_at"=> $this->created_at ? $this->created_at->toDateTimeString() : null,
            "updated_at"=> $this->updated_at ? $this->updated_at->toDateTimeString() : null,
        );
    }
}
