<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions'
    ];

    public function hasAccess(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check for single permission
     * @param string $permission
     */
    protected function hasPermission(string $permission)
    {
        $permissions = json_decode($this->permissions, true);
        return $permissions[$permission] ?? false;
    }

    public function users()
    {
        return $this->belongsToMany(user::class);
    }
}
