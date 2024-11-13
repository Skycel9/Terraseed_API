<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    public string $message;
    public int $code;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $total = $this->collection->count();

        return array(
            "list"=> $this->collection->transform(function ($post) {
                return $post;
            }),
            "meta"=> [
                "total"=> $total
            ]
        );
    }
}
