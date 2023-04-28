<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    

    /**
     * @OA\Get(
     * path="/user/details",
     * summary="User Details",
     * description="",
     * operationId="User Details",
     * tags={"User"},
     * security={ {"passport": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */

    public function getUserDetails(Request $request)
    {
        try {
            if (isset($request->user_id) && $request->user_id != '') {
                $id = $request->user_id;
            } else {
                $id = Auth::user()->id;
            }
            $user = User::with(['roles'])->find($id);
            return $this->success($user, __('api.userdetailSuccess'));
        } catch (\Exception $e) {
            return $this->fail([], $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     * path="/updateprofile",
     * summary="Update Profile",
     * description="Update User Profile",
     * operationId="updateUserProfile",
     * tags={"User"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="User Detail",
     *    @OA\JsonContent(
     *       required={"name","email"},
     *       @OA\Property(property="name", type="string", format="name", example="Laravel Admin"),
     *       @OA\Property(property="email", type="string", format="email", example="laraveladmin@yopmail.com")    
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry,Some thing went wrong. Please try again")
     *        )
     *     )
     * )
     */

    public function updateProfile(Request $request)
    {
        try {
            // here
            $rules = [
                'name' => 'required',
                'profile_pic' => 'nullable|max:10240',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }

            DB::beginTransaction();

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
            DB::commit();
            return $this->success($user, trans('api.profileUpdate'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail([], $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     * path="/change-password",
     * summary="Change Password",
     * description="Change Password",
     * operationId="changePassword",
     * tags={"User"},
     * security={ {"passport": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Change Password",
     *    @OA\JsonContent(
     *       required={"currentpassword","password","confirmpassword"},
     *       @OA\Property(property="currentpassword", type="string", format="password", example="Moon@123"),
     *       @OA\Property(property="password", type="string", format="password", example="Moon@123"),
     *       @OA\Property(property="confirmpassword", type="string", format="password", example="Moon@123"),
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

    public function storeChangePassword(Request $request)
    {
        try {
            // dd('here')
            $rules = [            
                'currentpassword' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:8', // must be at least 10 characters in length
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[0-9]/', // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                    'confirmed'
                ],
            ];

            $message = [
                'password.regex' => __('api.strongPassword'), 
                'confirmpassword.same' =>__('api.confirmPassword')       
            ];
            
            $validator = Validator::make($request->all(), $rules,$message);
            if ($validator->fails()) {
                return $this->fail([], $validator->errors()->first());
            }

            if (!Hash::check($request->currentpassword, auth()->user()->password)) {
                return $this->fail([], trans('api.currentPasdswordNotmatch'));
            }
            DB::beginTransaction();
            $user  = User::find(auth()->user()->id);
            $user->password = bcrypt($request->password);
            $user->save();
            // $data = $this->userService->StoreChangePassword($request);
            DB::commit();
            return $this->success($user, trans('api.passwordChanged'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail([], $e->getMessage());
        }
    }
}
