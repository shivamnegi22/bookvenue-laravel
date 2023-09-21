<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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


    public function authorizeRoles($roles)

    {

        if (is_array($roles)) {

            return $this->hasAnyRoles($roles) || abort(401, 'This action is unauthorized.');

        }



        return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');

    }



    /**

    * Check multiple roles

    * @param array $roles

    */

    public function hasAnyRoles($roles)

    {

        return null !== $this->roles()->whereIn('slug', $roles)->first();

    }



    /**

    * Check one role

    * @param string $role

    */

    public function hasAnyRole($role)

    {

        return null !== $this->roles()->where('slug', $role)->first();

    }

    
    /**

     * Check for permissions

     * @param array $permissions

     */

    public function hasAccess(array $permissions)

    {

        foreach ($this->roles as $role) {

            if ($role->hasAccess($permissions)) {

                return true;

            }

        }

        return false;

    }



    public function roles()

    {

        return $this->belongsToMany(Role::class);

    }

    

    public function profile()

    {

        return $this->hasOne(Profile::class);

    }
}
