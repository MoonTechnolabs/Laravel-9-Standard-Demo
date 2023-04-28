<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Helpers\Helper;
use Carbon\Carbon;
use Defuse\Crypto\Crypto;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UserService extends Controller
{
    public function updateAdminProfile($request, $user)
    {
        $user->name = $request->name;
        if (isset($request->image) && $request->image != '') {
            if ($request->file('image')->isValid()) {
                /* Unlink Image */
                if ($user->getRawOriginal('image') != null) {
                    $imagePath = config('const.USERIMAGEPATH') . '/' . $user->getRawOriginal('image');
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $profileImage = $request->image;
                $profilelogoName = 'Profile-' . time() . '.' . $request->image->getClientOriginalExtension();
                $profileImage->move(config('const.USERIMAGEUPLOADPATH'), $profilelogoName);
                $user->image = $profilelogoName;
            }
        }
        $user->save();
        return $user;
    }

    /*
     * Update Admin Password
     */

    public function updateAdminPassword($request, $user)
    {
        if (!Hash::check($request->oldpassword, $user->password)) {
            return $this->response('error', __('admin.currentPasdswordNotmatch'));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->response('success', __('admin.passwordChangeSucess'));
    }

    /* Get User Details */

    public static function getUserDetails($id)
    {
        $data = User::with(['roles'])->find($id);
        return $data;
    }

    public function getUserList($request)
    {
        $searchArray = array();
        parse_str($request->fromValues, $searchArray);
        $query = User::whereHas('roles', function ($user) use ($searchArray) {
            if ($searchArray['role_id'] != '') {
                $user->whereId($searchArray['role_id']);
            }
        })->with('roles');
        if ($request->order == null) {
            $query->orderBy('users.id', 'desc');
        }
        if ($searchArray['status'] == 1) {
            $query->active();
        } elseif ($searchArray['status'] == 0) {
            $query->inactive();
        }

        /* Get Role Permissions */

        return Datatables::of($query)
            ->addColumn('role', function ($data) {
                if ($data->roles->count() > 0) {
                    return $data->getRoleNames()->implode(',');
                }
                return '';
            })
            ->addColumn('action', function ($data) {

                $edit = route('admin.users.edit', [$data]);
                $view = route('admin.users.show', [$data]);
                $delete = $data->id;
                $viewLink = '';
                $editLink = '';
                $deleteLink = '';
                $user = Auth::user();

                if ($user->can('list-user')) {
                    $viewLink = $view;
                }

                if ($user->can('delete-user')) {
                    $deleteLink = $delete;
                }

                if ($user->can('update-user')) {
                    $editLink = $edit;
                }

                if ($data->roles[0]->id == config('const.roleSuperAdmin')) {
                    $editLink = '';
                    $deleteLink = '';
                }
                return Helper::Action($editLink, $deleteLink, $viewLink);
            })
            ->addColumn('status', function ($data) {
                return Helper::status($data->status);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function destroy($user)
    {
        $deletedUser = $user->delete();
        return $deletedUser;
    }

    public function getInactiveUserByEmail($email)
    {
        return User::where('email', $email)->inactive()->first();
    }

    public function register($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    public function addEdit($request, $id)
    {
        if ($id != '') {
            $user = User::find($id);
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $role_id = $request->role_id;
        } else {
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = now();
            $role_id = $request->role_id;
        }

        $user->name = $request->name;
        $user->status = $request->status;
        $user->save();
        $user->syncRoles($role_id);
        return $user;
    }

    public function getUserByEmail($email, $role_id = "")
    {
        $query = User::where('email', $email);
        if ($role_id) {
            $query->whereHas('roles', function ($role) use ($role_id) {
                $role->where('role_id', $role_id);
            });
        }
        return $query->first();
    }

    /* Store Change Password */

    public function StoreChangePassword($request)
    {
        $user = User::find(auth()->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    /* Update Mobile User Profile */

    public function updateMyProfileMobile($request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;

        if (isset($request->profile_pic) && $request->profile_pic != '') {
            if ($request->file('profile_pic')->isValid()) {
                /* Unlink Image */
                if ($user->getRawOriginal('image') != null) {
                    $imagePath = config('const.USERIMAGEPATH') . '/' . $user->getRawOriginal('image');
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $profileImage = $request->profile_pic;
                $profilelogoName = 'Profile-' . time() . '.' . $request->profile_pic->getClientOriginalExtension();
                $profileImage->move(config('const.USERIMAGEUPLOADPATH'), $profilelogoName);
                $user->image = $profilelogoName;
            }
        }
        $user->save();
        return $user;
    }

    /* Email Verify */

    public function activation($token)
    {
        try {
            $data = User::where('email', Crypt::decryptString($token))->first();
            if ($data) {
                User::where(['email' => Crypt::decryptString($token)])->update(['email_verified_at' => Carbon::now()]);
                session()->flash('success', __('admin.emailverified'));
                return redirect()->route('success');
            } else {
                session()->flash('error', __('admin.emailverifyfail'));
                return redirect()->route('success');
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route('success');
        }
    }

    public function getAppUserCount()
    {
        return User::whereHas('roles', function ($role) {
            $role->whereId(config('const.roleUser'));
        })->count();
    }

    public function getAdminUserCount()
    {
        
        return User::whereHas('roles', function ($role) {
            $role->whereNotIn('id', [config('const.roleUser'), config('const.roleSuperAdmin')]);
        })->count();
    }
}
