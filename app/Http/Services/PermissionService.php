<?php

namespace App\Http\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function getAllPermissions()
    {
        return Permission::all();
    }
}
