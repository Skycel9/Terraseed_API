<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostmetaResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // By default, when function execute the code even the condition is not complete unlike
        // native php instruction "if"
        // Using anonymous function prevents this behavior

        // - We can also use ternary operator, but this method is an interesting alternative
        return array(
            "id" => $this->meta_id,
            "post_id" => $this->post_id,
            "meta_key" => $this->meta_key,
            "meta_value"=> $this->when(
                str_contains($this->meta_key, "_metadata"),
                // Use anonymous function to prevent unserialization when condition is not complete
                function () {
                    return unserialize($this->meta_value);
                },
                $this->meta_value
            )
        );
    }
}
