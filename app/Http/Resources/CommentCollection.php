<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends BaseCollection
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
            "list"=> $this->collection->transform(function ($comment) {
                return $comment;
            }),
            "meta"=> [
                "total"=> $total
            ]
        );
    }
}
