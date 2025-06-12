<?php

namespace App\Models\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements
    AuthenticatableContract
{
    use Authenticatable, Authorizable, MustVerifyEmail, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'user_id', 'id');
    }

    public function canRule($rule)
    {
        $permissions = $this->permissions->contains('name', $rule);
        if ($permissions) {
            return true;
        }
        return false;
    }

    public function hasPermissions($names)
    {
        $results = $this->permissions()
            ->whereIn('name', $names)
            ->pluck('name')
            ->toArray() ?? [];

        $perms = [];

        foreach ($names as $key => $name) {
            $perms[$key] = in_array($name, $results);
        }

        return $perms;
    }


    public function canRules($rule)
    {
        $permissions = $this->permissions;
        foreach ($permissions as $permission) {
            if ($permission->name == $rule) {
                return true;
            }
        }
        return false;
    }
}
