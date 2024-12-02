<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = array(
        "user_login", "user_display_name", "user_email", "user_password",
        "user_phone_number", "user_phone_ext", "user_lastname",
        "user_firstname", "user_birthday", "user_gender"
    );

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts() {
        return $this->hasMany(Post::class, "author_id");
    }

    // Manage Authentication and permissions

    public function roles() {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function allPermissions()
    {
        $permissions = collect();

        foreach ($this->roles as $role) {
            $permissions = $permissions->merge($role->allPermissions());
        }


        return $permissions->unique(); // Keep unique permission in array
    }
    public function hasPermission($permissionName, $topicId = null) {
        // Get query for all roles of user
        $rolesQuery = $this->roles();

        if ($topicId) {
            $rolesQuery->where("topic_id", "=", $topicId);
        } else {
            $rolesQuery->where("topic_id", "=", null);
        }

        $roles = $rolesQuery->get();

        // Check permissions in each role
        foreach ($roles as $role) {
            $permissions = $role->allPermissions();
            if ($permissions->contains('perm_name', $permissionName)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($roleID) {
        return $this->roles()->where("role_id", $roleID)->exists();
    }

    public function rolesTopic($topicId) {
        return $this->roles()
            ->whereHas('topic', function ($query) use ($topicId) {
                $query->where('topics.id', $topicId);
            })
            ->get();
    }

    public function getAuthPassword()
    {
        return $this->user_password; // Replace 'password' by 'user_password' in auth system
    }

    public function likes() {
        return $this->belongsToMany(Content::class, "likes", "user_id", "post_id");
    }

    /*public function roles() {
        return $this->belongsToMany(Role::class, "users_roles");
    }
    public function rolesForTopic($topicId) {
        return $this->roles()->where("topic_id", $topicId);
    }
    public function hasPermission($permissionName, $topicId = null) {
        $query = $this->roles()->whereHas("permissions", function ($query) use ($permissionName) {
            $query->where("perm_name", $permissionName);
        });

        return $query->exists();
    }*/
}
