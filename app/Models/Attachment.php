<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    protected $table = "posts";

    use HasFactory;

    public $fillable = array(
        "post_slug", "post_type",
        "post_author", "post_parent", "updated_by",
        "deleted_by"
    );

    public function author() {
        return $this->belongsTo(User::class, 'post_author');
    }
    public function metas() {
        return $this->hasMany(Postmeta::class, "post_id", "id");
    }
}
