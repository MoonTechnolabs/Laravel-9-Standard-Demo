<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ForgotPasswordEmailSendRequest;
use App\Http\Services\UserService;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PasswordResetController extends Controller
{
    public $userService, $authService;
    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function forgotpasswordShow(){
        return view('admin.auth.forgotpassword');
    }


    public function forgotPassword(ForgotPasswordEmailSendRequest $request){        
        try {
            $user = $this->userService->getUserByEmail($request->email);            
            if (empty($user)) {
                return redirect()->route('password.request')->withErrors(__('admin.notfoundEmail'))->withInput();
            }
            if ($user->roles[0]->id == config('const.roleUser')) {
                session()->flash('error', trans('admin.notfoundEmail'));
                return redirect()->route('admin.login.show');
            }
            if ($user->status == config('const.statusInActiveInt')) {
                session()->flash('error', trans('admin.accountInactive'));
                return redirect()->route('admin.login.show');
            }
            $token = Crypt::encryptString($request->email);
            $this->authService->updateOrCreate($user, $token);
            session()->flash('success', trans('admin.forgotPassword'));
            return redirect()->route('admin.login.show');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route('admin.login.show');
        }
    }

    public function resetPassword($token)
    {
        $passwordReset = $this->authService->getPasswordResetToken($token);
        if (!$passwordReset) {
            return redirect(route('admin.login.show'))->withErrors(__('admin.InvalidResetPassword'));
        }
        return view('admin.auth.reset', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {

        return $this->authService->updatePassword($request->password, $request->token, '');
    }
}
