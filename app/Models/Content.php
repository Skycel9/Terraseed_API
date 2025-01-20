<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = "posts";

    public function author() {
        return $this->belongsTo(User::class, 'post_author');
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }
}
