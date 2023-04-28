<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\PermissionService;
use App\Http\Services\RoleService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    protected $title_name;
    protected $route;
    protected $singular_name;
    public $roleService;
    public $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {


        $this->middleware('permission:list-role|create-role|update-role|delete-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;

        $this->title_name = 'Roles';
        $this->singular_name = 'Role';
        $this->route = 'roles';

        view()->share("title", $this->title_name);
        view()->share("singular_name", $this->singular_name);
        view()->share("route", $this->route);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.' . $this->route . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $permissions = $this->permissionService->getAllPermissions();
        $datas = [];
        foreach ($permissions as $key => $permission) {
            $datas[Str::ucfirst(Str::afterLast($permission->name, '-'))] = [];
        }
        // dd($datas);
        // $datas = collect($datas)->unique()->flatten();
        foreach ($permissions as $key => $permission) {
            $datas[Str::ucfirst(Str::afterLast($permission->name, '-'))][$key] = $permission;
        }
        return view('admin.' . $this->route . '.create', compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->roleService->store($request);
            DB::commit();
            session()->flash('success', __('admin.rolecreatesuccess'));
            return redirect()->route('admin.' . $this->route . '.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permissions = $this->permissionService->getAllPermissions();
        $datas = [];
        foreach ($permissions as $key => $permission) {
            $datas[Str::ucfirst(Str::afterLast($permission->name, '-'))] = [];
        }

        foreach ($permissions as $key => $permission) {
            $datas[Str::ucfirst(Str::afterLast($permission->name, '-'))][$key] = $permission;
        }
        $permissionsIds = $role->permissions()->pluck('id')->toArray();

        return view('admin.' . $this->route . '.show', compact('role', 'permissions', 'datas', 'permissionsIds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = $this->permissionService->getAllPermissions();
        $datas = [];
        foreach ($permissions as $key => $permission) {
            $datas[Str::ucfirst(Str::afterLast($permission->name, '-'))] = [];
        }
        
        foreach ($permissions as $key => $permission) {
            $datas[Str::ucfirst(Str::afterLast($permission->name, '-'))][$key] = $permission;
        }

        $role = $this->roleService->getRoleByIdWithPermission($id);
        $permissions = $this->permissionService->getAllPermissions();
        $permissionsIds = $role->permissions()->pluck('id')->toArray();
        return view('admin.' . $this->route . '.edit', compact('role', 'permissions', 'datas', 'permissionsIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try {

            DB::beginTransaction();
            $this->roleService->update($request, $role);
            DB::commit();
            session()->flash('success', __('admin.roleupdatesuccess'));
            return redirect()->route('admin.' . $this->route . '.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $role = $this->roleService->destroy($role);
            return Response::json($role);
        } catch (\Exception $e) {
            return Response::json($e);
        }
    }

    public function postRolesList(Request $request)
    {
        return $this->roleService->postRolesList($request);
    }
}
