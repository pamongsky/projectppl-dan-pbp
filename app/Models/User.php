<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['id', 'name', 'password'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('name', $roleName);
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class); // Adjust according to your relationship
    }

    // /**
    //  * Get the first role of the user (if any).
    //  *
    //  * @return string|null
    //  */
    // public function getFirstRole(): ?string
    // {
    //     return $this->roles->first()?->name;
    // }
}
