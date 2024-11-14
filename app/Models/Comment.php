<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "posts";

    use HasFactory;

    public $fillable = array(
        "post_content", "post_author", "post_type",
        "is_published"
    );
}
