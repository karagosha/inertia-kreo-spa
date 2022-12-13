<?php


namespace App\Traits;


trait HasRole
{
    public function hasRole($roles): bool
    {
        $roles = is_string($roles)
            ?  explode('|', $roles) : $roles;
        foreach ((array)$roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }
}
