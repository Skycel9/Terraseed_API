<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = array(
        "post_title", "post_slug", "post_description",
        "post_content", "post_coordinates", "post_type",
        "post_author", "updated_by", "deleted_by", "deleted_at"
    );
}
