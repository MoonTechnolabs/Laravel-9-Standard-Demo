<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Helpers\Helper;

class RoleService
{
   
   
    public function getRoleByIdWithPermission($id)
    {
        return Role::where('id', $id)->with('permissions')->first();
    }

    
    public function getAllRoles()
    {
       return Role::where('id','!=',config('const.roleSuperAdmin'))->get();
    }
}
