<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        $route = Route::currentRouteName();

        if ($route === "login" || $route === "register" || $route === "me") {
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

        return array(
            "id"=> $this->id,
            "displayName"=> $this->user_display_name,
            $this->mergeWhen($user?->hasRole(4), [
                "contact"=> [
                    "email"=> $this->user_email,
                    "phone"=> ["extension"=> $this->user_phone_ext, "number"=> $this->user_phone_number]
                ],
                "created_at"=> $this->created_at ? $this->created_at->toDateTimeString() : null,
                "updated_at"=> $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            ]),
            $this->mergeWhen($user?->hasRole(1), [
                "profile"=>[
                    "firstName"=> $this->user_firstname,
                    "lastName"=> $this->user_lastname,
                    "gender"=> $this->user_gender,
                    "birthday"=> $this->user_birthday
                ],
                "email_verified_at"=> $this->email_verified_at,
            ]),
//            "roles"=> new RoleCollection($this->whenLoaded("roles")),

        );
    }
}
