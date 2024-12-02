<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Comment extends Content
{
    public $fillable = array(
        "post_content", "post_author", "post_type",
        "post_parent", "is_published"
    );

    protected static function booted() {
        // Ajouter un scope global pour les attachments
        static::addGlobalScope('attachment', function (Builder $query) {
            $query->where('post_type', 'comment');
        });
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_parent');
    }
}
