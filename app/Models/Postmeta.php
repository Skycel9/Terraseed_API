<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postmeta extends Model
{
    protected $table = 'postmeta';

    use HasFactory;

    public $timestamps = false;

    public $fillable = array(
        "post_id", "meta_key", "meta_value"
    );

}
