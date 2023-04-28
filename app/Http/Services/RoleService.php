<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use App\Helpers\Helper;

class RoleService
{
    public function postRolesList(Request $request)
    {
        $query = Role::query();
        if ($request->order == null) {
            $query->orderBy('roles.id', 'desc');
        }
        $user = auth()->user();
        /* Get Role Permissions */
        return Datatables::of($query)
            ->addColumn('action', function ($data) use ($user) {                   
                $edit = route('admin.roles.edit', $data->id);
                $view =  route('admin.roles.show', $data->id);
                $delete = $data->id;
                $viewLink = '';
                $deleteLink = '';
                $editLink = '';
                
                if ($user->can('list-role')) {
                    $viewLink = $view;
                }
                
                if ($user->can('update-role') && $data->is_system_generated != 1) {
                    $editLink = $edit;
                }

                if ($user->can('delete-role') && $data->is_system_generated != 1) {
                    $deleteLink = $delete;
                }
                
                return Helper::Action($editLink, $deleteLink, $viewLink);
            })
            ->addColumn('is_system_generated', function ($data) {
                return Helper::IsSystemGeneratedRole($data->is_system_generated);
            })
            ->rawColumns(['action','is_system_generated'])
            ->make(true);
    }

    public function getRolesWithPermissions()
    {
    }

    public function store($request)
    {
        $role = Role::create([
            'name' => $request->name,
            'is_system_generated' => 0,
        ]);
        $role->syncPermissions($request->permissions);
        return $role;
    }

    public function getRoleByIdWithPermission($id)
    {
        return Role::where('id', $id)->with('permissions')->first();
    }

    public function update($request, $role)
    {
        $role->name = $request->name;
        $role->syncPermissions($request->permissions);
        return $role;
    }

    public function destroy($role)
    {
        $role->syncPermissions([]);
        $role = $role->delete();
        return $role;
    }

    public function getAllRoles()
    {
       return Role::where('id','!=',config('const.roleSuperAdmin'))->get();
    }
}
