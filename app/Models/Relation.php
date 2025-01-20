<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    protected $table = 'users_relations';

    protected $fillable = [
        'relation_status',
        'requester_id',
        'user_target_id',
    ];
}
