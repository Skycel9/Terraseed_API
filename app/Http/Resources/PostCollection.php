<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PostCollection extends BaseCollection
{
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
