<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailJob;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Crypt;
class EmailVerificationController extends Controller
{
    public $userService;
    public function __construct(UserService $userService){        
        $this->userService = $userService;        
    }
    public function index()
    {
        if(Auth::check()){          
           if(Auth::user()->email_verified_at !=null && Auth::user()->email_verified_at !=""){
               return redirect()->route("admin.dashboard");
           }            
        }
        return view('admin.errors.verifyemail');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect(route('admin.dashboard'));
    }

    public function resend(Request $request)
    {
        $isMobile = '0';        
        $token = Crypt::encryptString($request->user()->email);        
        dispatch(new SendEmailJob([
            '_blade' => 'email_verification',
            'subject' => trans('email.email_verification'),
            'email' => $request->user()->email,
            'name' => $request->user()->name,
            'token' => $token,
            'url' => route('activation', ['token' => $token, 'isMobile' => $isMobile]),
            'ismobile' => $isMobile
        ]));        
        return back()->with('message', 'Verification link sent!');
    }
    
    public function activation($token)
    {        
        return $this->userService->activation($token);
    }
}
