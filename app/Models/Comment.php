<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $table = "posts";

    use HasFactory;
    use SoftDeletes;

    public $fillable = array(
        "post_content", "post_author", "post_type",
        "is_published"
    );
}
