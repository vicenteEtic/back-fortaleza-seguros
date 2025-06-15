<?php

namespace App\Models\User;

use App\Models\Permission\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use App\Models\Permission\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements
    AuthenticatableContract
{
    use Authenticatable, Authorizable, MustVerifyEmail, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'is_active',
        'role_id',
        'email_verified_at',
        'password',
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


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function can($rule)
    {
        $permissions = $this->role->permissions->contains('name', $rule);
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


    public function cans($rule)
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
