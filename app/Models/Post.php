<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Post extends Content
{
    public $fillable = array(
        "post_title", "post_slug", "post_description",
        "post_content", "post_coordinates", "post_type",
        "post_author", "post_parent", "updated_by", "deleted_by", "deleted_at"
    );

    protected static function booted() {
        // Ajouter un scope global pour les attachments
        static::addGlobalScope('attachment', function (Builder $query) {
            $query->where('post_type', 'post');
        });
    }

    public function parent() {
        return $this->belongsTo(Topic::class, "id");
    }

    public function attachments() {
        return $this->hasMany(Attachment::class, "post_parent");
    }
}
