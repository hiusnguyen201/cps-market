<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function findRoleByName($name)
    {
        $role = Role::where("name", $name)->first();
        return $role ? $role : null;
    }
}