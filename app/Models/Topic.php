<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = array(
        "topic_title", "topic_slug", "topic_banner",
        "topic_icon", "topic_author", "updated_by",
        "deleted_by"
    );

    public function posts()
    {
        return $this->hasMany(Post::class, "post_parent");
    }
}
