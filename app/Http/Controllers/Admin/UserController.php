<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminChangePasswordRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Services\RoleService;
use App\Models\User;
use App\Http\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Helpers\Helper;

class UserController extends Controller {

    public $userService, $roleService;

    protected $title_name;
    protected $route;
    protected $singular_name;

    public function __construct(UserService $userService, RoleService $roleService) {
        $this->title_name = 'Users';
        $this->singular_name = 'User';
        $this->route = 'users';


        $this->middleware('permission:list-user|create-user|update-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
        $this->userService = $userService;
        $this->roleService = $roleService;

        view()->share("title", $this->title_name);
        view()->share("singular_name", $this->singular_name);
        view()->share("route", $this->route);
    }


    public function myprofile() {
        try {
            return view('admin.' . $this->route . '.myprofile', ['user' => auth()->user()]);
        } catch (Exception $e) {
            return $this->response('error', $e->getMessage());
        }
    }

    public function updateprofile(UpdateAdminProfileRequest $request, User $user) {
        try {
            // dd($request->all());
            $user = $this->userService->updateAdminProfile($request, $user);
            return $this->response('success', __('admin.profileUpdate'));
        } catch (Exception $e) {
            return $this->response('error', $e->getMessage());
        }
        // dd($user);
    }

    public function updatePassword(AdminChangePasswordRequest $request, User $user) {
        try {
            DB::beginTransaction();
            $this->userService->updateAdminPassword($request, $user);
            DB::commit();
            session()->flash('success', trans('admin.passwordChangeSucess'));
            return redirect()->route('admin.profile.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->route('admin.profile.index');
        }
    }

    public function postUsersList(Request $request) {
        return $this->userService->getUserList($request);
    }
}
