<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Controller;
use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use App\Models\LoginDevice;

class AuthController extends Controller
{
    use Common;
    /**
     * @OA\Post(
     * path="/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="laraveladmin@yopmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="Moon@123##"),
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = auth()->user();
                if ($user->roles[0]->pivot->role_id !== config('const.roleUser')) {
                    return $this->fail([], __('api.notAuthorizedMobile'));
                }

                if ($user->status ==  config('const.statusInActiveInt')) {
                    return $this->fail([], __('api.accountInactiveMobile'));
                }

                if (!$user->email_verified_at) {
                    return $this->fail([], __('api.accountNotVerifiedMobile'));
                }

                $tokenobj = $user->createToken('test-token');
                $user->token = $tokenobj->accessToken;
                return $this->success($user, __('api.loginSuccess'));
            } else {
                return $this->fail([], __('api.AuthenticationFail'));
            }
        } catch (\Exception $e) {
            return $this->fail([], $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     * path="/register",
     * summary="Sign up",
     * description="Register by name, email, password",
     * operationId="authRegister",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Register Here",
     *    @OA\JsonContent(
     *       required={"name","email","password","password_confirmation"},
     *       @OA\Property(property="name", type="string", format="text", example="Laravel Admin"),
     *       @OA\Property(property="email", type="string", format="email", example="laraveladmin@yopmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="Moon@123##"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="Moon@123##"),
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function register(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8', // must be at least 8 characters in length
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[0-9]/', // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                    'confirmed'
                ],
            ];
            $messsages = [
                'password.regex' => trans('api.strongPassword'),
            ];

            $validator = Validator::make($request->all(), $rules, $messsages);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::commit();
            $token = Crypt::encryptString($request->email);
            dispatch(new SendEmailJob([
                '_blade' => 'email_verification',
                'subject' => trans('email.emailverify'),
                'email' => $request->email,
                'name' => $request->name,
                'token' => $token,
                'url' => route('account-activation', $token)
            ]));
            $role = Role::find(config('const.roleUser'));
            $user->assignRole($role->id);
            return $this->success($user, __('api.signupSuccess'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail([], $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     * path="/forgot-password",
     * summary="Forgot Password",
     * description="Forgot Password",
     * operationId="authForgotPassword",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Forgot Password",
     *    @OA\JsonContent(
     *       required={"email"},    
     *       @OA\Property(property="email", type="string", format="email", example="laraveladmin@yopmail.com"),        
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, email address not found in our record. Please try again")
     *        )
     *     )
     * )
     */

    public function forgotPassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }

            $query = User::whereEmail($request->email);
            $role_id = config('const.roleUser');
            $query->whereHas('roles', function ($role) use ($role_id) {
                $role->whereRoleId($role_id);
            });
            $user = $query->first();

            if (!$user) {
                return $this->fail([], __('api.notfoundEmail'));
            }

            if (isset($user) && $user->email_verified_at == '') {
                return $this->fail([], __('api.accountNotVerifiedMobile'));
            }

            if (isset($user) && $user->status == config('const.statusInActiveInt')) {
                return $this->fail([], __('api.accountInactiveMobile'));
            }

            //$token = Crypt::encryptString($request->email);

            $securityCode = $this->generateSecurityCode();

            $user->security_code = $securityCode;
            PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => $securityCode, 'created_at' => Carbon::now()]);
            $this->forgotLink($user->email, $securityCode, $user->name);

            return $this->success([], __('api.forgotPassword'));
        } catch (\Exception $e) {
            return $this->fail([], $e->getMessage());
        }
    }
    /* Send ForgotPassword SecurityCode */
    public function forgotLink($email, $securityCode, $name)
    {
        dispatch(new SendEmailJob([
            '_blade' => 'mobileforgot',
            'subject' => trans('email.resetPassword'),
            'email' => $email,
            'name' => $name,
            'security_code' => $securityCode
        ]));
    }

    /**
     * @OA\Post(
     * path="/reset-password",
     * summary="Reset Password",
     * description="Reset Password",
     * operationId="authRestPassword",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Reset Password",
     *    @OA\JsonContent(
     *       required={"email","security_code","password"},    
     *       @OA\Property(property="email", type="string", format="email", example="laraveladmin@yopmail.com"),     
     *      @OA\Property(property="security_code", type="string", format="text", example="AbCd78"),
     *      @OA\Property(property="password", type="string", format="password", example="Moon@123##"),
     *     @OA\Property(property="password_confirmation", type="string", format="password", example="Moon@123##"),
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Server Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address not found. Please try again")
     *        )
     *     )
     * )
     */
    public function resetPassword(Request $request)
    {
        try {

            $rules = [
                'password' => [
                    'required', 'min:8', 'confirmed', 'string',
                    'min:8', // must be at least 8 characters in length
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[0-9]/', // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ]
            ];

            $messages = [
                'password.regex' => __('api.strongPassword'),
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }

            $tokenData =  PasswordReset::where('email', $request->email)->first();
            if (empty($tokenData)) {
                return $this->fail([], __('api.InvalidResetPassword'));
            }
            if ($tokenData->token != $request->security_code) {
                return $this->fail([], __('api.InvalidSecurityCode'));
            }

            $user = User::whereEmail($tokenData->email)->first();
            $user->password = Hash::make($request->password);
            $user->update();
            PasswordReset::whereEmail($user->email)->delete();
            return $this->success([], __('api.passwordResetSuccess'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route('admin.login.show');
        }
    }

    /* Check Device Is Available */
    public static function checkDeviceAvailable($user_id, $type, $deviceID)
    {
        return LoginDevice::where('platform', $type)
            ->where('user_id', $user_id)
            ->where('device_id', $deviceID)
            ->first();
    }

    /* Store Device Info */
    public function storeDeviceInfo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'push_token' => 'required',
                'device_name' => 'required',
                'device_id' => 'required',
                'user_id' => 'required',
                'app_version' => 'required',
                'os_version' => 'required',
                'time_zone' => 'required',
                'platform' => 'required'
            ]);

            if ($validator->fails()) {
                return $this::fail([], $validator->errors()->first());
            }
            $user_id = auth()->user()->id;
            $alreadyData = self::checkDeviceAvailable($user_id, $request->platform, $request->device_id);

            if (!$alreadyData) {
                $userDevice = self::insertDevice($user_id, $request);                
                return $userDevice;
            } else {
                $data = LoginDevice::find($alreadyData->id);
                $data->push_token = $request->push_token;
                $data->updated_at = Carbon::now();
                $data->device_id = $request->device_id;
                $data->user_id = $user_id;
                if (isset($request->os_version)) {
                    $data->os_version = $request->os_version;
                }
                if (isset($request->device_name)) {
                    $data->device_name = $request->device_name;
                }
                if (isset($request->platform)) {
                    $data->platform = $request->platform;
                }
                if (isset($request->app_version)) {
                    $data->app_version = $request->app_version;
                }
                if (isset($request->time_zone)) {
                    $data->time_zone = $request->time_zone;
                }
                $data->save();
            }

            // $data = LoginDevice::deviceTokenManagement($request, Auth::user()->id);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->fail([], $e->getMessage());
        }
    }

    public static function insertDevice($user_id, $request)
    {
        $data = new LoginDevice();
        $data->user_id = $user_id;
        $data->push_token = $request->push_token;
        $data->device_id = $request->device_id;
        if (isset($request->os_version)) {
            $data->os_version = $request->os_version;
        }
        if (isset($request->device_name)) {
            $data->device_name = $request->device_name;
        }

        if (isset($request->platform)) {
            $data->platform = $request->platform;
        }
        if (isset($request->app_version)) {
            $data->app_version = $request->app_version;
        }
        if (isset($request->time_zone)) {
            $data->time_zone = $request->time_zone;
        }
        $data->save();
        return $data;
    }
}
