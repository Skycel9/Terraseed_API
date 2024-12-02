<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        "tag_name", "tag_slug", "tag_description",
        "tag_color", "updated_by", "deleted_by"
    ];

    public function author() {
        return $this->belongsTo(User::class, "tag_author");
    }
    public function posts() {
        return $this->belongsToMany(Post::class, "taged", "tag_id", "post_id");
    }
}
