<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Attachment extends Content
{
    public $fillable = array(
        "post_slug", "post_type",
        "post_author", "post_parent", "updated_by",
        "deleted_by"
    );

    protected static function booted() {
        // Ajouter un scope global pour les attachments
        static::addGlobalScope('attachment', function (Builder $query) {
            $query->where('post_type', 'attachment');
        });
    }


    public function metas() {
        return $this->hasMany(Postmeta::class, "post_id", "id");
    }
    public function post() {
        return $this->belongsTo(Post::class, 'post_parent');
    }
}
