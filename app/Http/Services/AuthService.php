<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\URL;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\Common;

class AuthService
{
    use Common;
    public function authenticate($request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $roles = $user->roles[0];
                if ($roles->id == config('const.roleUser')) {
                    Auth::logout();
                    return back()->withInput()->withError(__('admin.notAuthorizedAdmin'));
                }
                if ($user->status == config('const.statusInActiveInt')) {
                    Auth::logout();
                    return back()->withInput()->withError(__('admin.accountInactive'));
                }

                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
                User::where('id',auth()->user()->id)->update(["timezone"=>$request->timezone]);
            }
            return back()->withInput()->withError(__('admin.AuthenticationFail'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }
    /*Password Reset Update or Create */

    public function updateOrCreate($user,$token)
    {
        PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => $token, 'created_at' => Carbon::now()]);        
        $this->forgotLink($token, $user->email, $user->name);
    }

     /* Admin Forgot Password Send Link*/
     public function forgotLink($token, $email,$name){                       
        dispatch(new SendEmailJob([
            '_blade' => 'password_reset',
            'subject' => trans('email.resetPassword'),
            'email' => $email,
            'name' => $name,
            'token' => $token,
            'url' => route('password.reset', ['token' => $token]),            
        ]));       
    }

    /* Update Password */
    public function updatePassword($password, $token,$isMobile='')
    {        
        try {
            $tokenData =  PasswordReset::where('token', $token)->first(); 
            if (!$tokenData) {
                return $this->fail([], trans('api.InvalidSecurityCode'));
            }
            if (empty($tokenData)) {                 
                if (isset($isMobile) && $isMobile == 1) {                    
                    $this->fail([], trans('api.InvalidResetPassword'));                    
                } else {
                    session()->flash('error', trans('admin.InvalidResetPassword'));
                    return redirect()->route('resetpasswordform');
                }
            }  
            $user = User::where('email',$tokenData->email)->first();                
            $user->password = Hash::make($password);            
            $user->update();            
            PasswordReset::where('email', $user->email)->delete();            
            if (isset($isMobile) && $isMobile == 1) { 
                return $this->success([], trans('api.passwordResetSuccess'));                                                     
            } else {
                session()->flash('success', trans('admin.passwordResetSuccess'));
               return redirect()->route('admin.login.show');
            }
        } catch (\Exception $e) {     
            dd($e->getMessage());       
            session()->flash('error', $e->getMessage());
            return redirect()->route('admin.login.show');
        }
    }

    /* Logout */
    public function logout($request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login.show'));
    }

    /* Get Reset Password Token */
    public function getPasswordResetToken($token)
    {
        return PasswordReset::whereToken($token)->first();
    }
}
