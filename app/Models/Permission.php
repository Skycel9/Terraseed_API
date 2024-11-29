<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $fillable = [
        "perm_name"
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
