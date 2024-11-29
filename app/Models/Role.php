<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    public $fillables = [
        "role_name", "role_display_name", "topic_id"
    ];

    public function parentRole() {
        return $this->belongsTo(Role::class, "permissions_source_role_id");
    }
    public function permissions() {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
    public function topic() {
        return $this->belongsTo(Topic::class); // Un rôle peut être lié à un topic spécifique.
    }

    public function allPermissions()
    {
        $permissions = $this->permissions;

        // Récupérer les permissions des rôles parents
        if ($this->parentRole) {
            $permissions = $permissions->merge($this->parentRole?->allPermissions());
        }

        return $permissions;
    }
    /*public function permissions() {
        return $this->belongsToMany(Permission::class, 'roles_permissions', "id", "perm_id");
    }*/
}
